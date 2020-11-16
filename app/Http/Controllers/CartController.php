<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Category;
use App\Product;
use App\Link;
use App\Cart;
use App\User;

class CartController extends Controller
{
    public function index($lang , $user , $country)
    {

        $links = Link::all();
        $user = User::find($user);
        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        return view('cart' , compact('countries' , 'scountry' , 'user'  , 'links' ));
    }


    public function add($lang , $user , Request $request , $product )
    {



        $product = Product::find($product);
        $user = User::find($user);

        $cart = $user->cart;

        $scountry = Country::findOrFail($request->country);


        $cart->products()->attach($product->id);




        return view('_cart_button', compact( 'product' , 'user' , 'scountry'));

    }//end of products


    public function remove($lang , $user , Request $request , $product , $scountry )
    {

        $links = Link::all();
        $scountry = Country::findOrFail($scountry);
        $countries = Country::all();

        $product = Product::find($product);
        $user = User::find($user);

        $cart = $user->cart;



        $cart->products()->detach($product->id);






        return view('cart' , compact('countries' , 'scountry' , 'user'  , 'links' ));

    }//end of products
}
