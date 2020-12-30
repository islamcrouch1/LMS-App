<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\User;
use App\Product;
use App\Country;
use App\Link;


use App\Classes\PaymentService;
use App\WalletRequest;

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
        $scountry = Country::findOrFail($country);


        $request->validate([
            'products' => 'required|array',
            'address_id' => 'required|string',
            'used_balance'=>'required|string',
        ]);



        $count = 0 ;

        foreach($request->products as $key => $product){
            $product = Product::find($key);
            if($product->stock <= '0'){
                $user->cart->products()->detach($product->id);
                $count = $count + 1 ;
            }
        }

        if($count > 0){

            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'عزيزي العميل تم ازالة بعض المنتجات من سلة االمشتريات لعدم توفرها في المخزون حاليا');

            }else{

                session()->flash('success' , 'Dear customer, some products have been removed from the shopping cart because they are not currently in stock');
            }

            return redirect()->route('cart',['lang'=>app()->getLocale() , 'user'=>$user->id, 'country'=>$scountry->id ]);
        }


        $links = Link::all();
        $countries = Country::all();

        $used_balance = $request->used_balance;
        $balance = $user->wallet->balance;

        if($used_balance > $balance){

            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'رصيدك الحالي في المحفظة لا يكفي لإتمام الطلب');

            }else{

                session()->flash('success' , 'Your current wallet balance is insufficient to complete the order');
            }

            return redirect()->route('cart',['lang'=>app()->getLocale() , 'user'=>$user->id, 'country'=>$scountry->id ] );
        }



        $orderid = time().rand(999,9999) ;

        $order = $this->attach_order($request, $user , $orderid , $used_balance);


        if($order->total_price == '0'){

            if($used_balance > 0){

                $user->wallet->update([

                    'balance' => $user->wallet->balance - $used_balance ,
                ]);

                $request_ar = 'استخدام رصيد في شراء منتجات من المكتبة';
                $request_en = 'Use the credit to buy items from the library';
                $wallet_request = WalletRequest::create([
                    'user_id' => $user->id,
                    'wallet_id' => $user->wallet->id,
                    'status'=>'done',
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => - $used_balance,
                    'orderid' => '1' ,
                ]);
            }

            return redirect()->route('success-order-library' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'OrderID'=>$orderid , 'Result'=>'CAPTURED']);

        }else{

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
            $payment->setSuccessUrl(route('success-order-library' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'used_balance' => $used_balance]))->setErrorUrl(route('error-order-library' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]));
            $result = $payment->pay($array);
            if($result['status'] == "success") {

                return redirect(url($result['paymentURL']));
                // $paymentURL = $result['paymentURL'];
                // return redirect()->$paymentURL ;
            }else{

                return redirect()->route('error-order-library' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'OrderID'=>$orderid]);
            }

        }




    }



    public function PaymentSuccess(Request $request) {

        $order = Order::where('orderid' , $request->OrderID)->first();
        $user = User::findOrFail($order->user_id);
        $links = Link::all();
        $scountry = Country::findOrFail($user->country->id);
        $countries = Country::all();

        if($request->Result == 'CAPTURED') {

            if($request->used_balance > 0){

                $user->wallet->update([

                    'balance' => $user->wallet->balance - $request->used_balance ,
                ]);

                $request_ar = 'استخدام رصيد في شراء منتجات من المكتبة';
                $request_en = 'Use the credit to buy items from the library';


                $wallet_request = WalletRequest::create([
                    'user_id' => $user->id,
                    'wallet_id' => $user->wallet->id,
                    'status'=>'done',
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => - $request->used_balance,
                    'orderid' => $order->orderid ,
                ]);

            }

            foreach ($order->products as $product) {


                $product->update([
                    'stock' => $product->stock - $product->pivot->quantity
                ]);

            }//end of foreach

            foreach ($user->cart->products as $product) {

                $user->cart->products()->detach($product->id);

            }

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







    private function attach_order($request, $user , $orderid , $used_balance)
    {

        $shipping = 0;

        if($user->cart->products->where('type' , 'physical_product')->count() > '0'){

            $shipping = $user->country->shipping;

        }

        $order = $user->orders()->create([
            'total_price' => 0 ,
            'address_id' => $request->address_id,
            'status' => 'recieved',
            'payment_status' => "waiting",
            'orderid'=> $orderid,
            'country_id'=>$user->country->id,
            'user_name'=>$user->name,
            'wallet_balance'=>$used_balance,
            'shipping' => $shipping,
        ]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id => $quantity) {

            $product = Product::FindOrFail($id);



            $total_price += $product->sale_price * $quantity['quantity'];



        }//end of foreach

        $total_price = $total_price - $used_balance + $shipping ;

        $order->update([
            'total_price' => $total_price
        ]);




        return $order ;

    }//end of attach order
}
