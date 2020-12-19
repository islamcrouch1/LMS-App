<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Country;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    protected function authenticated(Request $request, $user){


        $scountry = Country::findOrFail($request->country);

        if($user->HasRole('user')){
            return redirect(route('profile' , ['lang'=> app()->getLocale(), 'user'=>$user->id , 'country'=> $scountry]));
        }
        if($user->HasRole(['superadministrator' , 'administrator'])){
            return redirect(route('dashboard', app()->getLocale()));
        }
    }



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function redirectTo(){
    //     return app()->getLocale() . '/home';
    // }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect(route('home' , ['lang'=> app()->getLocale() , 'country'=> '1']));
    }

    public function username()
    {
        return 'phone';
    }
}
