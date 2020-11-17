<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\User;
use App\Product;
use App\Country;
use App\Link;


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

        $this->attach_order($request, $user);



        $links = Link::all();
        $scountry = Country::findOrFail($country);
        $countries = Country::all();

        return view('order_done' , compact('countries' , 'scountry' , 'user'  , 'links' ));


    }









    private function attach_order($request, $user)
    {
        $order = $user->orders()->create([
            'total_price' => 0 ,
            'address_id' => $request->address_id,
            'status' => 'recieved',
        ]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id => $quantity) {

            $product = Product::FindOrFail($id);


            $user->cart->products()->detach($id);

            $total_price += $product->sale_price * $quantity['quantity'];

            $product->update([
                'stock' => $product->stock - $quantity['quantity']
            ]);

        }//end of foreach

        $order->update([
            'total_price' => $total_price
        ]);

    }//end of attach order
}
