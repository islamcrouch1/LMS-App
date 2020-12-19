<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Country;
use App\Order;
use App\Address;
use App\Link;
use App\User;



class MyCoursesController extends Controller
{
    public function index($lang , $user , $country)
    {

        $links = Link::all();
        $user = User::find($user);

        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        return view('my-courses' , compact('countries' , 'scountry' , 'user'  , 'links' ));
    }
}
