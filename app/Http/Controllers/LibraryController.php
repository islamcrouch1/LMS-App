<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Country;
use App\Category;
use App\Product;
use App\Link;



class LibraryController extends Controller
{
    public function index($lang ,  $scountry)
    {
        // $category = Category::all();

        $links = Link::all();


        $products = Product::paginate(8);
        $categories = Category::with('products')->get();
        $scountry = Country::findOrFail($scountry);
        $countries = Country::all();
        return view('library' , compact('countries' , 'scountry' , 'categories'  , 'products' , 'links' ));
    }


    public function products($lang , $category , $scountry)
    {

        $links = Link::all();

        $scategory = Category::find($category);


        $products = Product::where('category_id' , $scategory->id)
        ->whenSearch(request()->search)
        ->paginate(8);

        $categories = Category::with('products')->get();
        $scountry = Country::findOrFail($scountry);
        $countries = Country::all();
        return view('_category_products', compact('countries', 'scountry' , 'products' , 'categories' , 'links' , 'scategory'));

    }//end of products


}
