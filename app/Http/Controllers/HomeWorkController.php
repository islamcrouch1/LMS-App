<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Course;
use App\HomeWork;
use App\Link;
use App\User;
use App\Jobs\StreamVideo;
use App\HomeWorkOrder;

use App\Teacher;

use App\HomeWorkComment;

use App\Notification;

use App\Events\NewNotification;




use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class HomeWorkController extends Controller
{
    public function index($lang , $user , $country)
    {


        $links = Link::all();
        $user = User::find($user);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();


        return view('homework' , compact('countries' , 'scountry' , 'user'  , 'links' ));


    }

    public function createRequest($lang , $user , $country , Request $request)
    {


        $links = Link::all();
        $user = User::find($user);

        $order = HomeWorkOrder::findOrFail($request->order);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();


        return view('homework-request' , compact('countries' , 'scountry' , 'user'  , 'links' , 'order' ));


    }


    public function storeRequest($lang , $user , $country , Request $request)
    {

        $request->validate([

            'student_note' => "string",
            'student_file' => "nullable|file",
            'student_image' => "nullable|image",
            'homework_title' => "required|string"
            ]);





        $links = Link::all();
        $user = User::find($user);

        $order = HomeWorkOrder::findOrFail($request->order);

        $teacher = User::find($order->teacher_id);
        $course = Course::find($order->course_id);

        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();


        if($order->quantity <= 0){

            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'عزيزي الطالب لا يمكنك ارسال الطلب حاليا ، ليس لديك رصيد لحل واجباتك');

            }else{

                session()->flash('success' , 'Dear student, you cannot send the application now, you do not have credit to do your homework');
            }

            return redirect()->route('homework' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);

        }else{

            $order->update([

                'quantity'=> $order->quantity - 1 ,

            ]);


            if($request->hasFile('student_image')){

                Image::make($request['student_image'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/homework/' . $request['student_image']->hashName()) , 60);

                $image = $request['student_image']->hashName();

            }else{
                $image = '#';
            }


            if($request->hasFile('student_file')){


                $fileName = time(). '-' . '.'.$request['student_file']->extension();

                $request['student_file']->move(public_path('storage/homework/files'), $fileName);
            }else{
                $fileName = '#';
            }




            $homeworkRequest = HomeWork::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'teacher_name' => $teacher->name,
                'country_id'=>$user->country->id,
                'teacher_id' => $teacher->id,
                'course_id' => $course->id,
                'homework_title'=> $request['homework_title'],
                'home_work_order_id'=> $order->id,
                'student_note' => $request['student_note'],
                'student_image' => $image,
                'student_file' => $fileName,

            ]);



                $title_ar = 'طلب حل واجب';
                $body_ar = 'لقد قام ' . $user->name . 'بعمل طلب حل واجب جديد ';
                $title_en = 'Homework Request';
                $body_en  = $user->name . ' made a new assignment request' ;




            $notification = Notification::create([
                'user_id' => $teacher->id,
                'user_name'  => $user->name,
                'user_image' => asset('storage/images/users/' . $user->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar ,
                'title_en' => $title_en,
                'body_en' => $body_en ,
                'date' => $homeworkRequest->created_at,
                'url' =>  route('teacher.homework' , ['lang'=>app()->getLocale() , 'user'=>$teacher->id ,  'country'=>$scountry->id]),
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
                'date' => $homeworkRequest->created_at->format('Y-m-d H:i:s'),
                'status'=> $notification->status,
                'url' =>  route('teacher.homework' , ['lang'=>app()->getLocale() , 'user'=>$teacher->id ,  'country'=>$scountry->id]),
                'change_status' =>  route('notification-change', ['lang'=>app()->getLocale() , 'user'=>$teacher->id , 'country'=>$scountry->id , 'notification'=>$notification->id]),

           ];


           event(new NewNotification($data));

            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'تم ارسال طلبك بنجاح');

            }else{

                session()->flash('success' , 'Requset Sent Successfully');
            }

            return redirect()->route('homework' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);





        }




    }


    public function editRequest($lang , $user , $country , Request $request)
    {


        $links = Link::all();
        $user = User::find($user);

        $homeworkRequest = HomeWork::findOrFail($request->homeworkRequest);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();


        return view('homework-request-edit' , compact('countries' , 'scountry' , 'user'  , 'links' , 'homeworkRequest' ));


    }



    public function updateRequest($lang , $user , $country , Request $request)
    {

        $request->validate([

            'student_note' => "string",
            'student_file' => "nullable|file",
            'student_image' => "nullable|image",
            'homework_title' => "required|string"
            ]);





        $links = Link::all();
        $user = User::find($user);

        $homeworkRequest = HomeWork::findOrFail($request->homeworkRequest);

        $teacher = User::find($homeworkRequest->teacher_id);
        $course = Course::find($homeworkRequest->course_id);

        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();


        if($homeworkRequest->status != 'waiting'){

            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'عزيز الطالب لا يمكنك التعديل على الطلب ، لقد قام المدرس باستلام طلبك بالفعل يرجى التواصل معه عن طريق صفحة الطلب');

            }else{

                session()->flash('success' , 'Dear student, you cannot amend the request, the teacher has already received your request, please contact him through the request page');
            }

            return redirect()->route('homework' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);

        }else{




            if($request->hasFile('student_image')){

                if($homeworkRequest->student_image == '#'){

                    Image::make($request['student_image'])->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/images/homework/' . $request['student_image']->hashName()) , 60);

                    $image = $request['student_image']->hashName();
                }else{

                    Storage::disk('public')->delete('/images/homework/' . $homeworkRequest->student_image);

                    Image::make($request['student_image'])->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/images/homework/' . $request['student_image']->hashName()) , 60);

                    $image = $request['student_image']->hashName();
                }

            }else{
                $image = $homeworkRequest->student_image;
            }


            if($request->hasFile('student_file')){

                if($homeworkRequest->student_file == '#'){

                    $fileName = time(). '-' . '.'.$request['student_file']->extension();

                    $request['student_file']->move(public_path('storage/homework/files'), $fileName);

                }else{

                    Storage::disk('public')->delete('/homework/files/' . $homeworkRequest->student_file);

                    $fileName = time(). '-' . '.'.$request['student_file']->extension();

                    $request['student_file']->move(public_path('storage/homework/files'), $fileName);
                }

            }else{
                $fileName = $homeworkRequest->student_file;
            }




            $homeworkRequest->update([

                'homework_title'=> $request['homework_title'],
                'student_note' => $request['student_note'],
                'student_image' => $image,
                'student_file' => $fileName,

            ]);


            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'تم تعديل طلبك بنجاح');

            }else{

                session()->flash('success' , 'Requset Updated Successfully');
            }

            return redirect()->route('homework' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);





        }




    }



    public function showSolution($lang , $user , $country , Request $request)
    {


        $links = Link::all();
        $user = User::find($user);

        $homeworkRequest = HomeWork::findOrFail($request->homeworkRequest);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();

        return view('show-solution' , compact('countries' , 'scountry' , 'user'  , 'links'  , 'homeworkRequest' ));

    }

    public function rating($lang , $user , $country , Request $request)
    {



        $links = Link::all();
        $user = User::find($user);

        $homeworkRequest = HomeWork::findOrFail($request->homeworkRequest);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();

        $teacher = Teacher::where('user_id' , $homeworkRequest->teacher_id)->first();



        $rating = $homeworkRequest->rating([
            'title' => $request->title,
            'body' => '#',
            'rating' => $request->rate_homework,
            'recommend' => 'Yes',
            'approved' => true, // This is optional and defaults to false
        ], $user);



            $requests = HomeWork::where('teacher_id' , $homeworkRequest->teacher_id)->get();


            $average = 0;
            $count = 0 ;
            $x = 0 ;

            foreach($requests as $request){
                if(($request->averageRating(2)[0] != null)){
                    $count = $count + 1 ;
                    $average = $average + $request->averageRating(2)[0];
                }
            }

            if($count == 0){
                $average = 0 ;
            }else{
                $average = $average / $count ;
            }



            $teacher->update([

                'average' => $average ,
            ]);




        if(app()->getLocale() == 'ar'){

            session()->flash('success' , 'تم تقييم الخدمة بنجاح');

        }else{

            session()->flash('success' , 'The service was rated successfully');
        }

        return redirect()->route('homework' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);






    }

    public function sendComment($lang , $user , $country , Request $request)
    {


        $links = Link::all();
        $user = User::find($user);

        $homeworkRequest = HomeWork::findOrFail($request->homeworkRequest);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();



        if($request->hasFile('comment_image')){

            Image::make($request['comment_image'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/comments/' . $request['comment_image']->hashName()) , 60);

            $image = $request['comment_image']->hashName();

        }else{
            $image = '#';
        }


        if($request->hasFile('comment_file')){


            $fileName = time(). '-' . '.'.$request['comment_file']->extension();

            $request['comment_file']->move(public_path('storage/comments/files'), $fileName);
        }else{
            $fileName = '#';
        }



        $homeworkComment = HomeWorkComment::create([
            'user_id' => $user->id,
            'home_work_id' => $homeworkRequest->id,
            'message'=> $request['message'],
            'comment_image' => $image,
            'comment_file' => $fileName ,

        ]);



        if($user->teacher != null){
            $reciever = User::find($homeworkComment->home_work->user_id);;
            $sender = $user;
            $url = route('homework-show' , ['lang'=>app()->getLocale() , 'user'=>$reciever->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkComment->home_work->id]);
        }else{
            $reciever = User::find($homeworkComment->home_work->teacher_id);
            $sender = $user;
            $url = route('teacher.interact' , ['lang'=>app()->getLocale() , 'user'=>$reciever->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkComment->home_work->id]);
        }


        $title_ar = 'تعليق جديد';
        $body_ar = 'لقد قام ' . $sender->name . ' بكتابة تعليق جديد لك ' ;
        $title_en = 'New Comment';
        $body_en  = 'teacher ' . $sender->name . ' has written a new comment for you';

    $notification = Notification::create([
        'user_id' => $reciever->id,
        'user_name'  => $sender->name,
        'user_image' => asset('storage/images/users/' . $sender->profile),
        'title_ar' => $title_ar,
        'body_ar' => $body_ar ,
        'title_en' => $title_en,
        'body_en' => $body_en ,
        'date' => $homeworkComment->created_at,
        'url' =>  $url,
    ]);



    $data =[
        'notification_id' => $notification->id,
        'user_id' => $reciever->id,
        'user_name'  => $sender->name,
        'user_image' => asset('storage/images/users/' . $sender->profile),
        'title_ar' => $title_ar,
        'body_ar' => $body_ar ,
        'title_en' => $title_en,
        'body_en' => $body_en ,
        'date' => $homeworkComment->created_at->format('Y-m-d H:i:s'),
        'status'=> $notification->status,
        'url' =>  $url,
        'change_status' =>  route('notification-change', ['lang'=>app()->getLocale() , 'user'=>$reciever->id , 'country'=>$scountry->id , 'notification'=>$notification->id]),

   ];


   event(new NewNotification($data));





        return view('_comment_homework' , compact('countries' , 'scountry' , 'user'  , 'links'  , 'homeworkRequest' , 'homeworkComment' ));


    }



}
