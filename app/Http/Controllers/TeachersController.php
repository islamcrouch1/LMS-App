<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Course;
use App\Teacher;
use App\Link;
use App\User;
use App\HomeWork;

use App\Jobs\StreamVideo;

use App\HomeWorkOrder;

use App\Notification;

use App\Events\NewNotification;


use App\Classes\PaymentService;



class TeachersController extends Controller
{
    public function index($lang , $country)
    {


        $links = Link::all();

        $users = Teacher::orderBy('average', 'desc')->paginate(16);

        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        return view('teachers' , compact('countries' , 'scountry' , 'users'  , 'links' ));
    }

    public function courseTeachers($lang , $course  ,  $country )
    {



        $course = Course::findOrFail($course);

        $links = Link::all();

        $users = $course->teachers;



        $users = $users->sortBy(function($user){
            return $user->average;
        });



        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        return view('_course_teachers' , compact('countries' , 'scountry' , 'users'  , 'links' ));
    }

    public function teacherShow($lang , $user  ,  $country )
    {


        $user = User::findOrFail($user);
        $links = Link::all();

        $requests = HomeWork::where('teacher_id' , $user->id)->get();


        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        return view('teacher-show' , compact('countries' , 'scountry' , 'user'  , 'links' , 'requests' ));


    }


    public function addOrder($lang , $user  ,  $country ,Request $requset )
    {


        $user = User::findOrFail($user);
        $links = Link::all();
        $scountry = Country::findOrFail($country);
        $countries = Country::all();

        $quantity = $requset->quantity;

        $teacher = User::findOrFail($requset->teacher);

        $course = Course::findOrFail($requset->selectedCourse);

        $price = $course->homework_price;

        $total_price = $quantity * $price ;

        $orderid = time().rand(999,9999) ;


        $homeworkorder = HomeWorkOrder::create([
            'user_id' => $user->id,
            'teacher_id' => $teacher->id,
            'user_name' => $user->name,
            'teacher_name' => $teacher->name,
            'country_id'=>$user->country->id,
            'course_id' => $course->id,
            'quantity' => $quantity,
            'total_price' => $total_price,
            'orderid' => $orderid ,
            'status' => 'waiting',

        ]);





        $payment = new PaymentService();


        $array['CstFName']                    = $user->name;
        $array['CstEmail']                    = $user->email;
        $array['CstMobile']                   = $user->phone;
        $array['payment_gateway']             = 'knet'; // cc || knet
        $array['total_price']                 = $total_price;
        $array['order_id']                    = $orderid;
        $array['products']['ProductName']     = 'Payment for homework request - ' . $course->name_en . ' - ' . $course->ed_class->name_en;
        $array['products']['ProductQty']      = $quantity;
        $array['products']['ProductPrice']    = $price;
        $array['CurrencyCode']                = $user->country->currency;
        $payment->setSuccessUrl(route('success-order' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]))->setErrorUrl(route('error-order' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]));
        $result = $payment->pay($array);
        if($result['status'] == "success") {

            return redirect(url($result['paymentURL']));
            // $paymentURL = $result['paymentURL'];
            // return redirect()->$paymentURL ;
        }else{

            return redirect()->route('error-order' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'OrderID'=>$orderid]);
        }


        // return view('teacher-show' , compact('countries' , 'scountry' , 'user'  , 'links' ));
    }


    public function PaymentSuccess(Request $request) {

        $homeworkOrder = HomeWorkOrder::where('orderid' , $request->OrderID)->first();
        $user = User::findOrFail($homeworkOrder->user_id);
        $links = Link::all();
        $scountry = Country::findOrFail($user->country->id);
        $countries = Country::all();

        $teacher = User::find($homeworkOrder->teacher_id);

        if($request->Result == 'CAPTURED') {

            $homeworkOrder->update([
                'status' => "done",
            ]);



            $title_ar = 'طلب شراء جديد لخدمة حل الواجب';
            $body_ar = 'لقد قام ' . $user->name . 'بشراء خدمة حل الواجب منك ';
            $title_en = 'A new purchase request for the assignment service';
            $body_en  = $user->name . ' has purchased an assignment service from you' ;




        $notification = Notification::create([
            'user_id' => $teacher->id,
            'user_name'  => $user->name,
            'user_image' => asset('storage/images/users/' . $user->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar ,
            'title_en' => $title_en,
            'body_en' => $body_en ,
            'date' => $homeworkOrder->created_at,
            'url' =>  route('finances' , ['lang'=>app()->getLocale() , 'user'=>$teacher->id ,  'country'=>$scountry->id]),
        ]);



        $data =[
            'notification_id' => $notification->id,
            'user_id' => $teacher->id,
            'user_name'  => $user->name,
            'user_image' => asset('storage/images/users/' . $user->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar ,
            'title_en' => $title_en,
            'body_en' => $body_en ,
            'date' => $homeworkOrder->created_at->format('Y-m-d H:i:s'),
            'status'=> $notification->status,
            'url' =>  route('finances' , ['lang'=>app()->getLocale() , 'user'=>$teacher->id ,  'country'=>$scountry->id]),
            'change_status' =>  route('notification-change', ['lang'=>app()->getLocale() , 'user'=>$teacher->id , 'country'=>$scountry->id , 'notification'=>$notification->id]),

       ];


       event(new NewNotification($data));

            return view('done-payment-homework' , compact('countries' , 'scountry' , 'user'  , 'links' ));
        }

        return redirect()->route('error-order' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'OrderID'=>$orderid]);
    }

    public function PaymentError(Request $request) {


        $homeworkOrder = HomeWorkOrder::where('orderid' , $request->OrderID)->first();


        $user = User::findOrFail($homeworkOrder->user_id);



        $links = Link::all();
        $scountry = Country::findOrFail($user->country->id);
        $countries = Country::all();

        return view('failed-payment' , compact('countries' , 'scountry' , 'user'  , 'links' ));


    }







}
