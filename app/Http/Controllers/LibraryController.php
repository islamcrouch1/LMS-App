<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Country;
use App\Category;
use App\Product;
use App\Link;

use \AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;



class LibraryController extends Controller
{
    public function index($lang ,  $country)
    {
        // $category = Category::all();

        $links = Link::all();
        $scountry = Country::findOrFail($country);
        $countries = Country::all();


        $categories = Category::with('products')
        ->where('country_id' , $scountry->id)
        ->get();

        $products = Product::where('country_id' , $scountry->id)
        ->whenSearch(request()->search)
        ->paginate(8);


        return view('library' , compact('countries' , 'scountry' , 'categories'  , 'products' , 'links' ));
    }


    public function products($lang , $category , $country)
    {

        $links = Link::all();
        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        $scategory = Category::find($category);


        $products = Product::where('category_id' , $scategory->id)
        ->whenSearch(request()->search)
        ->paginate(8);

        $categories = Category::with('products')
        ->where('country_id' , $scountry->id)
        ->get();


        return view('_category_products', compact('countries', 'scountry' , 'products' , 'categories' , 'links' , 'scategory'));

    }//end of products


}
