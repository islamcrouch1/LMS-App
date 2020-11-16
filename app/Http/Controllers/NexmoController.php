<?php

namespace App\Http\Controllers;

use Auth;
use Nexmo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\LearningSystem;
use App\Country;


class NexmoController extends Controller
{
    public function show(Request $request) {
        $scountry = Country::findOrFail($request->country);
        $learning_systems = LearningSystem::all();
        $countries = Country::all();
        return view('nexmo' , compact('learning_systems' , 'countries' , 'scountry' ));
    }

    public function verify(Request $request) {
         $this->validate($request, [
             'code' => 'size:4'
         ]);

         $request_id = session('nexmo_request_id');
         $verification = new \Nexmo\Verify\Verification($request_id);

         Nexmo::verify()->check($verification, $request->code);

         $date = date_create();
         DB::table('users')->where('id', Auth::id())->update(['phone_verified_at' => date_format($date, 'Y-m-d H:i:s')]);

         return redirect(route('home' , ['lang'=> app()->getLocale() , 'country'=> '1']));
    }
}
