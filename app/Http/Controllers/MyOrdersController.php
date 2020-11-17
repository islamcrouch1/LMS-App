<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Order;
use App\Address;
use App\Link;
use App\User;

class MyOrdersController extends Controller
{
    public function index($lang , $user , $country)
    {

        $links = Link::all();
        $user = User::find($user);

        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        return view('my-orders' , compact('countries' , 'scountry' , 'user'  , 'links' ));
    }


    public function products($lang , Order $order , $country , Request $request)
    {


        $user = User::find($request->user);


        $links = Link::all();

        $scountry = Country::findOrFail($country);
        $countries = Country::all();

        $products = $order->products;
        return view('_my-orders_products', compact('order', 'products' , 'user' , 'countries' , 'scountry' , 'links' ));

    }//end of products
}
