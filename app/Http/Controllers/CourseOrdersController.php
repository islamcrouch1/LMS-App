<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Course;
use App\Teacher;
use App\Link;
use App\User;
use App\UserLesson;
use App\CourseOrder;

use App\Jobs\StreamVideo;

use App\HomeWorkOrder;


use App\Classes\PaymentService;
use App\WalletRequest;

class CourseOrdersController extends Controller
{
    public function addOrder($lang , $user  ,  $country ,Request $requset )
    {


        $user = User::findOrFail($user);
        $links = Link::all();
        $scountry = Country::findOrFail($country);
        $countries = Country::all();

        $used_balance = $requset->used_balance ;


        $balance = $user->wallet->balance;

        if($used_balance > $balance){

            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'رصيدك الحالي في المحفظة لا يكفي لإتمام الطلب');

            }else{

                session()->flash('success' , 'Your current wallet balance is insufficient to complete the order');
            }

            return redirect()->route('teachers' , ['lang' => app()->getLocale() , 'country'=>$scountry->id]);
        }




        $course = Course::findOrFail($requset->course);

        $price = $course->course_price;

        $price = $price  - $used_balance ;

        $orderid = time().rand(999,9999) ;


        if($price == '0'){



            $course_order = CourseOrder::create([
                'user_id' => $user->id,
                'country_id' => $user->country_id,
                'user_name'=>$user->name,
                'course_id' => $course->id,
                'total_price' => $price,
                'orderid' => $orderid ,
                'status' => 'done',
                'wallet_balance'=> $used_balance,

            ]);


            if($used_balance > 0){

                $user->wallet->update([

                    'balance' => $user->wallet->balance - $used_balance ,
                ]);

                $request_ar = 'استخدام رصيد في شراء كورسات تعليمية';
                $request_en = 'Using credit to buy educational courses';


                $wallet_request = WalletRequest::create([
                    'user_id' => $user->id,
                    'wallet_id' => $user->wallet->id,
                    'status'=>'done',
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => - $used_balance,
                    'orderid' => $course_order->orderid ,
                ]);

            }





            return redirect()->route('success-order-course' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'OrderID'=>$orderid , 'Result'=>'CAPTURED']);


        }else{


            $course_order = CourseOrder::create([
                'user_id' => $user->id,
                'country_id' => $user->country_id,
                'user_name'=>$user->name,
                'course_id' => $course->id,
                'total_price' => $price,
                'orderid' => $orderid ,
                'status' => 'waiting',
                'wallet_balance'=> $used_balance,

            ]);


            $payment = new PaymentService();


            $array['CstFName']                    = $user->name;
            $array['CstEmail']                    = $user->email;
            $array['CstMobile']                   = $user->phone;
            $array['payment_gateway']             = 'knet'; // cc || knet
            $array['total_price']                 = $price;
            $array['order_id']                    = $orderid;
            $array['products']['ProductName']     = 'Payment for homework request - ' . $course->name_en . ' - ' . $course->ed_class->name_en;
            $array['products']['ProductQty']      = '1';
            $array['products']['ProductPrice']    = $price;
            $array['CurrencyCode']                = $user->country->currency;
            $payment->setSuccessUrl(route('success-order-course' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'used_balance' => $used_balance]))->setErrorUrl(route('error-order-course' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]));
            $result = $payment->pay($array);
            if($result['status'] == "success") {

                return redirect(url($result['paymentURL']));
                // $paymentURL = $result['paymentURL'];
                // return redirect()->$paymentURL ;
            }else{

                return redirect()->route('error-order-course' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'OrderID'=>$orderid]);
            }


        }




        // return view('teacher-show' , compact('countries' , 'scountry' , 'user'  , 'links' ));
    }


    public function PaymentSuccess(Request $request) {

        $course_order = CourseOrder::where('orderid' , $request->OrderID)->first();
        $course = Course::find($course_order->course_id);
        $user = User::findOrFail($course_order->user_id);
        $links = Link::all();
        $scountry = Country::findOrFail($user->country->id);
        $countries = Country::all();

        if($request->Result == 'CAPTURED') {


            if($request->used_balance > 0){

                $user->wallet->update([

                    'balance' => $user->wallet->balance - $request->used_balance ,
                ]);

                $request_ar = 'استخدام رصيد في شراء كورسات تعليمية';
                $request_en = 'Using credit to buy educational courses';


                $wallet_request = WalletRequest::create([
                    'user_id' => $user->id,
                    'wallet_id' => $user->wallet->id,
                    'status'=>'done',
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => - $request->used_balance,
                    'orderid' => $course_order->orderid ,
                ]);

            }

            $course_order->update([
                'status' => "done",
            ]);

            foreach($course->chapters as $chapter){


                foreach($chapter->lessons as $lesson){

                    $user_lesson = UserLesson::create([

                        'user_id' => $user->id,
                        'lesson_id' => $lesson->id,
                        'course_id' => $course->id,
                        'watched' => 0,

                    ]);

                }
            }

            return view('order-done-course' , compact('countries' , 'scountry' , 'user'  , 'links' ));
        }

        return redirect()->route('error-order-course' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'OrderID'=>$orderid]);
    }

    public function PaymentError(Request $request) {


        $course_order = CourseOrder::where('orderid' , $request->OrderID)->first();


        $user = User::findOrFail($course_order->user_id);



        $links = Link::all();
        $scountry = Country::findOrFail($user->country->id);
        $countries = Country::all();

        return view('failed-payment' , compact('countries' , 'scountry' , 'user'  , 'links' ));


    }



}
