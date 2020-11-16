<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Category;
use App\Address;
use App\Link;
use App\User;

class AddressesController extends Controller
{
    public function index($lang , $user , $country)
    {

        $links = Link::all();
        $user = User::find($user);

        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        return view('addresses.index' , compact('countries' , 'scountry' , 'user'  , 'links' ));
    }

    public function create( $lang , $user , $country)
    {



        $user = User::find($user);
        $countries = Country::all();
        $links = Link::all();


        $scountry = Country::findOrFail($country);


        return view('addresses.create' , compact('countries' , 'scountry' , 'user'  , 'links' ));
    }









    public function store($lang , Request $request , $user , $country)
    {



        $user = User::find($user);




        $request->validate([

            'province' => "required|string",
            'city' => "required|string",
            'district' => "required|string",
            'street' => "required|string",
            'building' => "required|string",
            'phone' => "required|string",
            'notes' => "required|string",



            ]);


            $address = address::create([
                'province' => $request['province'],
                'city' => $request['city'],
                'district' => $request['district'],
                'building' => $request['building'],
                'street' => $request['street'],
                'phone' => $request['phone'],
                'notes' => $request['notes'],
                'user_id' => $user->id,
                'country_id' => $user->country->id,


            ]);




            $links = Link::all();
            $countries = Country::all();
            $scountry = Country::findOrFail($country);




            return view('addresses.index' , compact('countries' , 'scountry' , 'user'  , 'links' ));



    }

    public function edit($lang , $user , $address  , $country)
    {

        $user = User::find($user);


        $address = address::find($address);
        $links = Link::all();
        $countries = Country::all();
        $scountry = Country::findOrFail($country);
        return view('addresses.edit' , compact('countries' , 'scountry' , 'user'  , 'links' , 'address' ));
    }


    public function update($lang , $user , $address  , $country , Request $request)
    {



        $user = User::find($user);


        $address = address::withTrashed()->where('id' , $address)->first();



        $request->validate([

            'province' => "required|string",
            'city' => "required|string",
            'district' => "required|string",
            'street' => "required|string",
            'building' => "required|string",
            'phone' => "required|string",
            'notes' => "required|string",

            ]);



            $address->update([
                'province' => $request['province'],
                'city' => $request['city'],
                'district' => $request['district'],
                'building' => $request['building'],
                'street' => $request['street'],
                'phone' => $request['phone'],
                'notes' => $request['notes'],
                'user_id' => $user->id,
                'country_id' => $user->country->id,

            ]);







        $links = Link::all();
        $countries = Country::all();
        $scountry = Country::findOrFail($country);
        return view('addresses.index' , compact('countries' , 'scountry' , 'user'  , 'links'  ));


    }


    public function destroy($lang , $user ,  $address , $country ,  Request $request)
    {


        $user = User::find($user);

        $address = address::withTrashed()->where('id' , $address)->first();


            $address->delete();


            $links = Link::all();

            $countries = Country::all();
            $scountry = Country::findOrFail($country);

            return view('addresses.index' , compact('countries' , 'scountry' , 'user'  , 'links' ));


    }
}
