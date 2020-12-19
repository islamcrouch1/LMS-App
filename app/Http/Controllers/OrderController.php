<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\User;
use App\Product;
use App\Country;
use App\Link;


use App\Classes\PaymentService;



class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::whenSearch(request()->search)
        ->latest()
        ->paginate(5);

        return view('dashboard.orders.index')->with('orders' , $orders);
    }



    public function add($lang , Request $request , $user , $country)
    {




        $user = User::find($user);

        $request->validate([
            'products' => 'required|array',
            'address_id' => 'required|string',
        ]);



        $links = Link::all();
        $scountry = Country::findOrFail($country);
        $countries = Country::all();

        $orderid = time().rand(999,9999) ;

        $order = $this->attach_order($request, $user , $orderid);

        $payment = new PaymentService();


        $array['CstFName']                    = $user->name;
        $array['CstEmail']                    = $user->email;
        $array['CstMobile']                   = $user->phone;
        $array['payment_gateway']             = 'knet'; // cc || knet
        $array['total_price']                 = $order->total_price;
        $array['order_id']                    = $order->orderid;
        $array['products']['ProductName']     = 'Payment for library request - ' .  'order number - ' . $order->id ;
        $array['products']['ProductQty']      = '1';
        $array['products']['ProductPrice']    = $order->total_price;
        $array['CurrencyCode']                = $user->country->currency;
        $payment->setSuccessUrl(route('success-order-library' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]))->setErrorUrl(route('error-order-library' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]));
        $result = $payment->pay($array);
        if($result['status'] == "success") {

            return redirect(url($result['paymentURL']));
            // $paymentURL = $result['paymentURL'];
            // return redirect()->$paymentURL ;
        }else{

            return redirect()->route('error-order-library' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'OrderID'=>$orderid]);
        }


    }



    public function PaymentSuccess(Request $request) {

        $order = Order::where('orderid' , $request->OrderID)->first();
        $user = User::findOrFail($order->user_id);

        foreach ($order->products as $product) {


            $product->update([
                'stock' => $product->stock - $product->pivot->quantity
            ]);

        }//end of foreach

        foreach ($user->cart->products as $product) {

            $user->cart->products()->detach($product->id);

        }

        $links = Link::all();
        $scountry = Country::findOrFail($user->country->id);
        $countries = Country::all();

        if($request->Result == 'CAPTURED') {

            $order->update([
                'payment_status' => "done",
            ]);

            return view('order-done-library' , compact('countries' , 'scountry' , 'user'  , 'links' ));
        }

        return redirect()->route('error-order-course' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'OrderID'=>$orderid]);
    }

    public function PaymentError(Request $request) {


        $order = Order::where('orderid' , $request->OrderID)->first();


        $user = User::findOrFail($order ->user_id);



        $links = Link::all();
        $scountry = Country::findOrFail($user->country->id);
        $countries = Country::all();

        return view('failed-payment' , compact('countries' , 'scountry' , 'user'  , 'links' ));


    }







    private function attach_order($request, $user , $orderid)
    {
        $order = $user->orders()->create([
            'total_price' => 0 ,
            'address_id' => $request->address_id,
            'status' => 'recieved',
            'payment_status' => "waiting",
            'orderid'=> $orderid,
            'country_id'=>$user->country->id,
            'user_name'=>$user->name,
        ]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id => $quantity) {

            $product = Product::FindOrFail($id);



            $total_price += $product->sale_price * $quantity['quantity'];



        }//end of foreach

        $order->update([
            'total_price' => $total_price
        ]);


        return $order ;

    }//end of attach order
}
