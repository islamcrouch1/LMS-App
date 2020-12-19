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

use Carbon\Carbon;

use App\Notification;

use App\Events\NewNotification;
use DateTime;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class TeacherHomeWorkController extends Controller
{
    public function index($lang , $user , $country)
    {


        $links = Link::all();
        $user = User::find($user);

        $homeWorks = HomeWork::where('teacher_id' , $user->id)->get();


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();


        return view('teacher-homework' , compact('countries' , 'scountry' , 'user'  , 'links' , 'homeWorks' ));


    }


    public function interact($lang , $user , $country , Request $request)
    {


        $links = Link::all();
        $user = User::find($user);

        $homeworkRequest = HomeWork::findOrFail($request->homeworkRequest);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();


        return view('teacher-interact-homework' , compact('countries' , 'scountry' , 'user'  , 'links'  , 'homeworkRequest' ));


    }

    public function recieve($lang , $user , $country , Request $request)
    {


        $links = Link::all();
        $user = User::find($user);

        $homeworkRequest1 = HomeWork::findOrFail($request->homeworkRequest);




        if($homeworkRequest1->status == 'waiting'){

            $homeworkRequest1->update([

                'status' => 'recieved',
                'recieve_time' => Carbon::now()->toDateTimeString(),

            ]);

        }


        $homeWorks = HomeWork::where('teacher_id' , $user->id)->get();


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();

        $student = User::find($homeworkRequest1->user_id);


        $title_ar = 'تم استلام طلب حل الواجب';
        $body_ar = 'لقد قام المعلم ' . $user->name . 'باستلام طلبك ويقوم الأن بمراجعته ';
        $title_en = 'The assignment request request has been received';
        $body_en  = 'teacher ' . $user->name . ' has received your request and is reviewing it now' ;




    $notification = Notification::create([
        'user_id' => $student->id,
        'user_name'  => $user->name,
        'user_image' => asset('storage/images/users/' . $user->profile),
        'title_ar' => $title_ar,
        'body_ar' => $body_ar ,
        'title_en' => $title_en,
        'body_en' => $body_en ,
        'date' => $homeworkRequest1->recieve_time,
        'url' =>  route('homework' , ['lang'=>app()->getLocale() , 'user'=>$student->id ,  'country'=>$scountry->id]),
    ]);



    $data =[
        'notification_id' => $notification->id,
        'user_id' => $student->id,
        'user_name'  => $user->name,
        'user_image' => asset('storage/images/users/' . $user->profile),
        'title_ar' => $title_ar,
        'body_ar' => $body_ar ,
        'title_en' => $title_en,
        'body_en' => $body_en ,
        'date' => $homeworkRequest1->recieve_time,
        'status'=> $notification->status,
        'url' =>  route('homework' , ['lang'=>app()->getLocale() , 'user'=>$student->id ,  'country'=>$scountry->id]),
        'change_status' =>  route('notification-change', ['lang'=>app()->getLocale() , 'user'=>$student->id , 'country'=>$scountry->id , 'notification'=>$notification->id]),

   ];


   event(new NewNotification($data));



        if(app()->getLocale() == 'ar'){

            session()->flash('success' , 'تم استلام الطلب بنجاح' );

        }else{

            session()->flash('success' , 'Request Recieved Successfully');
        }


        return view('teacher-homework' , compact('countries' , 'scountry' , 'user'  , 'links' , 'homeWorks' , 'homeworkRequest1' ));


    }

    public function status($lang , $user , $country , Request $request)
    {


        $links = Link::all();
        $user = User::find($user);

        $homeworkRequest = HomeWork::findOrFail($request->homeworkRequest);

        $student = User::find($homeworkRequest->user_id);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();


        $homeworkRequest->update([

            'status' => $request->status,

        ]);

        switch($homeworkRequest->status){
            case('waiting'):

                    $status_ar = 'في انتظار استقبال الطلب من المدرس';
                    $status_en = 'Waiting to receive the request from the teacher';

            break;
            case('done'):
                    $status_ar = 'طلب مكتمل';
                    $status_en = 'Completed Request';

            break;
            case('recieved'):
                    $status_ar = 'تم استلام الطلب';
                    $status_en = 'Request Recieved';

            break;
            case('solution'):
                $status_ar = 'تم حل الواجب';
                $status_en = 'The solution is ready';
            break;

        }


        $title_ar = 'تم تغيير حالة طلب الواجب';
        $body_ar = 'لقد قام المعلم ' . $user->name . ' بتغيير حالة طلب حل الواجب الى ' . $status_ar ;
        $title_en = 'The assignment request\'s status has changed';
        $body_en  = 'teacher ' . $user->name . ' has changed the status of the request to ' . $status_en;


        $now = new DateTime();

    $notification = Notification::create([
        'user_id' => $student->id,
        'user_name'  => $user->name,
        'user_image' => asset('storage/images/users/' . $user->profile),
        'title_ar' => $title_ar,
        'body_ar' => $body_ar ,
        'title_en' => $title_en,
        'body_en' => $body_en ,
        'date' => $now->format('Y-m-d H:i:s'),
        'url' =>  route('homework' , ['lang'=>app()->getLocale() , 'user'=>$student->id ,  'country'=>$scountry->id]),
    ]);



    $data =[
        'notification_id' => $notification->id,
        'user_id' => $student->id,
        'user_name'  => $user->name,
        'user_image' => asset('storage/images/users/' . $user->profile),
        'title_ar' => $title_ar,
        'body_ar' => $body_ar ,
        'title_en' => $title_en,
        'body_en' => $body_en ,
        'date' => $now->format('Y-m-d H:i:s'),
        'status'=> $notification->status,
        'url' =>  route('homework' , ['lang'=>app()->getLocale() , 'user'=>$student->id ,  'country'=>$scountry->id]),
        'change_status' =>  route('notification-change', ['lang'=>app()->getLocale() , 'user'=>$student->id , 'country'=>$scountry->id , 'notification'=>$notification->id]),

   ];


   event(new NewNotification($data));




        if(app()->getLocale() == 'ar'){

            session()->flash('success' , 'تم تعديل حالة الطلب بنجاح' );

        }else{

            session()->flash('success' , 'The status of the request has been modified successfully');
        }

        return redirect()->route('teacher.interact' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkRequest->id]);



    }



    public function update($lang , $user , $country , Request $request)
    {

        $request->validate([

            'teacher_note' => "string",
            'teacher_file' => "nullable|file",
            'teacher_image' => "nullable|image",
            ]);





        $links = Link::all();
        $user = User::find($user);

        $homeworkRequest = HomeWork::findOrFail($request->homeworkRequest);

        $course = Course::find($homeworkRequest->course_id);

        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();






            if($request->hasFile('teacher_image')){

                if($homeworkRequest->teacher_image == '#'){

                    Image::make($request['teacher_image'])->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/images/homework/' . $request['teacher_image']->hashName()) , 60);

                    $image = $request['teacher_image']->hashName();
                }else{

                    Storage::disk('public')->delete('/images/homework/' . $homeworkRequest->teacher_image);

                    Image::make($request['teacher_image'])->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/images/homework/' . $request['teacher_image']->hashName()) , 60);

                    $image = $request['teacher_image']->hashName();
                }

            }else{
                $image = $homeworkRequest->teacher_image;
            }


            if($request->hasFile('teacher_file')){

                if($homeworkRequest->teacher_file == '#'){

                    $fileName = time(). '-' . '.'.$request['teacher_file']->extension();

                    $request['teacher_file']->move(public_path('storage/homework/files'), $fileName);

                }else{

                    Storage::disk('public')->delete('/homework/files/' . $homeworkRequest->teacher_file);

                    $fileName = time(). '-' . '.'.$request['teacher_file']->extension();

                    $request['teacher_file']->move(public_path('storage/homework/files'), $fileName);
                }

            }else{
                $fileName = $homeworkRequest->teacher_file;
            }




            $homeworkRequest->update([

                'teacher_note' => $request['teacher_note'],
                'teacher_image' => $image,
                'teacher_file' => $fileName,

            ]);


            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'تم حفظ البيانات بنجاح قم بتغيير حالة الطلب الى تم الحل لكي يستطيع الطالب من مشاهدة الحل');

            }else{

                session()->flash('success' , 'Data Saved Successfully');
            }

            return redirect()->route('teacher.interact' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkRequest->id]);




    }

    public function toggle_favorite($lang , $user  ,  $country , Request $requset )
    {
        $user = User::find($user);

        $teacher = $user->teacher;

        $teacher->is_favored ? $teacher->users()->detach(auth()->user()->id) : $teacher->users()->attach(auth()->user()->id);

    }// end of toggle_favorite


    public function show_favorite($lang , $user  ,  $country)
    {


        $links = Link::all();

        $user = User::find($user);

        $users = $user->teachers;


        $users = $users->sortBy(function($user){
            return $user->average;
        });



        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        return view('fav_teachers' , compact('countries' , 'scountry' , 'users'  , 'links' ));
    }


}
