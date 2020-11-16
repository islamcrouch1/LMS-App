<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Country;
use Nexmo;
use App\Cart;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    protected $redirectTo = '/nexmo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
{
    $countries = Country::all();
    return view("auth.register", compact("countries"));
}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country' => ['required'],
            'phone' => ['required','string', 'unique:users'],
            'gender' => ['required'],
            'profile' => ['required','image'],
            'type' => ['required','string']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {


        $verification = Nexmo::verify()->start([
            'number' => $data['phone'],
            'brand' => 'Phone Verification',
        ]);

        session(['nexmo_request_id' => $verification->getRequestId()]);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'country_id' => $data['country'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'profile' => $data['profile']->store('images', 'public'),
                'type' => $data['type']
            ]);

            $user->attachRole('user');
            return $user;

            Cart::create([
                'user_id' => $user->id,
            ]);





    }

    public function redirectTo(){
         return route('nexmo' , ['lang'=> app()->getLocale() , 'country'=> '1']);
    }
}
