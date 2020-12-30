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
use App\Link;
use App\Teacher;
use App\BankInformation;
use App\Wallet;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;


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

    // protected $redirectTo = '/nexmo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm($lang ,Request $request)
{
    $links = Link::all();
    $scountry = Country::findOrFail($request->country);
    $countries = Country::all();
    return view("auth.register", compact('countries' , 'scountry' , 'links'));
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
                'profile' => ['image'],
                'type' => ['required','string'],
                'parent_phone' => ['string'],
                'parent_phone_hide' => ['string'],
                'phone_hide' => ['string'],
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


        // $verification = Nexmo::verify()->start([
        //     'number' => $data['phone'],
        //     'brand' => 'Phone Verification',
        // ]);

        // session(['nexmo_request_id' => $verification->getRequestId()]);





            if(!array_key_exists('profile', $data)){
                if($data['gender'] == 'male'){
                    $data['profile'] = 'avatarmale.png' ;
                }else{
                    $data['profile'] = 'avatarfemale.png' ;
                }
            }else{


                Image::make($data['profile'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/users/' . $data['profile']->hashName()) , 60);
            }



            if($data['profile'] == 'avatarmale.png' || $data['profile'] == 'avatarfemale.png'){
                $image = $data['profile'];
            }else{
                $image = $data['profile']->hashName();
            }


            // if(!array_key_exists('parent_phone', $data)){

            //         $data['parent_phone'] = '#' ;

            // }


            $data['phone'] = str_replace(' ', '', $data['phone']);
            $data['parent_phone'] = str_replace(' ', '', $data['parent_phone']);
            $data['phone'] = $data['phone_hide'] . $data['phone'] ;
            $data['parent_phone'] = $data['parent_phone_hide'] . $data['parent_phone'] ;





            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'country_id' => $data['country'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'profile' => $image,
                'type' => $data['type'],
                'parent_phone' => $data['parent_phone'],
                ]);




            $user->attachRole('user');

            Cart::create([
                'user_id' => $user->id,
            ]);

            Wallet::create([
                'user_id' => $user->id,
            ]);

            if($user->type == 'teacher'){
                Teacher::create([
                    'user_id' => $user->id,
                ]);

                BankInformation::create([
                    'user_id' => $user->id,
                ]);
            }



            return $user;



    }

    // public function redirectTo(){
    //      return route('nexmo' , ['lang'=> app()->getLocale() , 'country'=> '1']);
    // }

    protected function registered(Request $request, User $user)
    {
        $user->callToVerify();
        return redirect($this->redirectPath($request , $user));
    }

}
