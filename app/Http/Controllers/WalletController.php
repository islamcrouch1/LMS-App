<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Category;
use App\Product;
use App\Link;
use App\Cart;
use App\User;
use App\Wallet;

use App\WalletRequest;

use App\Classes\PaymentService;



class WalletController extends Controller
{
    public function index($lang , $user , $country)
    {

        $links = Link::all();
        $user = User::find($user);
        $wallet_requests = WalletRequest::where('user_id' , $user->id)
        ->where('status' , 'done')
        ->paginate(20);
        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        return view('wallet' , compact('countries' , 'scountry' , 'user'  , 'links' , 'wallet_requests' ));
    }


    public function addBalance($lang , $user  ,  $country ,Request $request )
    {

        $request->validate([

            'balance' => "required|string",

        ]);


        $user = User::findOrFail($user);
        $scountry = Country::findOrFail($country);

        $wallet = Wallet::find($user->id);

        $balance = $request->balance;

        $orderid = time().rand(999,9999) ;

        $request_ar = 'طلب شراء رصيد';
        $request_en = 'Request to purchase credit';



        $wallet_request = WalletRequest::create([
            'user_id' => $user->id,
            'wallet_id' => $wallet->id,
            'status'=>'waiting',
            'request_ar' => $request_ar,
            'request_en' => $request_en,
            'balance' => $request->balance,
            'orderid' => $orderid ,
        ]);





        $payment = new PaymentService();


        $array['CstFName']                    = $user->name;
        $array['CstEmail']                    = $user->email;
        $array['CstMobile']                   = $user->phone;
        $array['payment_gateway']             = 'knet'; // cc || knet
        $array['total_price']                 = $balance;
        $array['order_id']                    = $orderid;
        $array['products']['ProductName']     = 'Payment for balance request - ' . $user->name ;
        $array['products']['ProductQty']      = '1';
        $array['products']['ProductPrice']    = $balance;
        $array['CurrencyCode']                = $user->country->currency;
        $payment->setSuccessUrl(route('success-request-wallet' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]))->setErrorUrl(route('error-request-wallet' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]));
        $result = $payment->pay($array);
        if($result['status'] == "success") {

            return redirect(url($result['paymentURL']));
            // $paymentURL = $result['paymentURL'];
            // return redirect()->$paymentURL ;
        }else{

            return redirect()->route('error-request-wallet' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'OrderID'=>$orderid]);
        }


        // return view('teacher-show' , compact('countries' , 'scountry' , 'user'  , 'links' ));
    }


    public function PaymentSuccess(Request $request) {

        $wallet_request = WalletRequest::where('orderid' , $request->OrderID)->first();
        $wallet = Wallet::find($wallet_request->wallet_id);
        $user = User::findOrFail($wallet_request->user_id);
        $links = Link::all();
        $scountry = Country::findOrFail($user->country->id);
        $countries = Country::all();

        if($request->Result == 'CAPTURED') {

            $wallet_request->update([
                'status' => "done",
            ]);


            $wallet->update([

                'balance' => $wallet->balance + $wallet_request->balance,

            ]);



            return view('success-request-wallet' , compact('countries' , 'scountry' , 'user'  , 'links' ));
        }

        return redirect()->route('error-request-wallet' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'OrderID'=>$orderid]);
    }

    public function PaymentError(Request $request) {


        $wallet_request = WalletRequest::where('orderid' , $request->OrderID)->first();


        $user = User::findOrFail($wallet_request->user_id);



        $links = Link::all();
        $scountry = Country::findOrFail($user->country->id);
        $countries = Country::all();

        return view('failed-payment' , compact('countries' , 'scountry' , 'user'  , 'links' ));


    }



}
