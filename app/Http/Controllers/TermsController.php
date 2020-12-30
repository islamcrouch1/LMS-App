<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Category;
use App\Product;
use App\Link;

class TermsController extends Controller
{
    public function index($lang ,  $country)
    {
        // $category = Category::all();

        $links = Link::all();
        $scountry = Country::findOrFail($country);
        $countries = Country::all();



        return view('terms' , compact('countries' , 'scountry' , 'links' ));
    }
}
