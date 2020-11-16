<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EdClass;
use App\Country;
use App\Link;

class EdClassesController extends Controller
{
    public function index($lang , $ed_class , $scountry)
    {

        $links = Link::all();

        $scountry = Country::findOrFail($scountry);
        $ed_class = EdClass::findOrFail($ed_class);
        $countries = Country::all();
        return view('ed_classes' , compact('ed_class' , 'countries' , 'scountry' , 'links' ));
    }
}
