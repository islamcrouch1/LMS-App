<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;

use App\Country;
use App\Link;
use App\LearningSystem;
use App\Post;
use App\Ad;
use App\Sponser;
use App\User;
use Illuminate\Support\Facades\Redirect;

class PhoneVerificationController extends Controller
{
    public function show(Request $request)
    {


        $links = Link::all();
        $scountry = Country::findOrFail($request->country);
        $countries = Country::all();
        $ads = Ad::all();
        $sponsers = Sponser::all();
        $posts = Post::all();
        $learning_systems = LearningSystem::all();



        return $request->user()->hasVerifiedPhone()
                        ? view('profile' , compact('countries' , 'scountry' , 'links' ))->with( 'user' , $request->user() )
                        : view('verifyphone' , compact('countries' , 'scountry' , 'links' ));
    }

    public function verify($lang , Request $request , $country)
    {



        $links = Link::all();
        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        $ads = Ad::all();
        $sponsers = Sponser::all();
        $posts = Post::all();
        $learning_systems = LearningSystem::all();




        if ($request->user()->verification_code !== $request->code) {
            if(app()->getLocale() == "en"){
                throw ValidationException::withMessages([
                    'code' => ['The code your provided is wrong. Please try again or request another call.'],
                ]);
            }else{
                throw ValidationException::withMessages([
                    'code' => ['الكود الذي ادخلته غير صحيح , يرجى المحاولة مره اخرى'],
                ]);
            }

        }

        if ($request->user()->hasVerifiedPhone()) {
            return view('profile' , compact('countries' , 'scountry' , 'links' ))->with( 'user' , $request->user() );
        }

        $request->user()->markPhoneAsVerified();

        // return redirect()->route('home')->with('status', 'Your phone was successfully verified!');

        return view('profile' , compact( 'countries' , 'scountry' , 'links' ))->with( 'user' , $request->user() );

    }


    public function resend($lang , $user , $country , Request $request)
    {


        $user = User::find($user);
        $user->callToVerify();


        return Redirect::back();


    }
}
