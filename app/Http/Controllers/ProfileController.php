<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Order;
use App\Teacher;
use App\Link;
use App\User;
use App\Jobs\StreamVideo;

use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class ProfileController extends Controller
{
    public function index($lang , $user , $country)
    {


        $links = Link::all();
        $user = User::find($user);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();
        return view('profile' , compact('countries' , 'scountry' , 'user'  , 'links' ));


    }

    public function saveCourses(Request $request){


        $request->validate([

            'courses' => "array",

            ]);





            $links = Link::all();
            $user = User::find($request->user);


            $user->courses()->sync($request->courses);


            $user->teacher->courses()->sync($request->courses);

            $scountry = Country::findOrFail($request->country);
            $countries = Country::all();

            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'تم الحفظ بنجاح');

            }else{

                session()->flash('success' , 'Data Saved Successfully');
            }


            return redirect()->route('profile' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);

    }



    public function saveInfo(Request $request){


        $user = User::find($request->user);
        $teacher =  $user->teacher;


        // $request->validate([

        //     'description_ar' => "string",
        //     'description_en' => "string",
        //     'study_plan' => "string",

        //     ]);



            $teacher->update([
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_en'],
                'study_plan' => $request['study_plan'],

            ]);





            $links = Link::all();
            $scountry = Country::findOrFail($request->country);
            $countries = Country::all();

            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'تم الحفظ بنجاح');

            }else{

                session()->flash('success' , 'Data Saved Successfully');
            }



            return redirect()->route('profile' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);

    }




    public function activate( $lang , $user , $country)
    {

      $user = User::find($user);


      $teacher =  $user->teacher;

      $teacher->update([
          'status' => 1 ,
      ]);



      if(app()->getLocale() == 'ar'){

        session()->flash('success' , 'تم تنشيط الحساب بنجاح');

        }else{

            session()->flash('success' , 'Account Activated Successfully');
        }

      $links = Link::all();
      $scountry = Country::findOrFail($country);
      $countries = Country::all();

      return redirect()->route('profile' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);



    }


    public function deactivate( $lang , $user , $country)
    {


        $user = User::find($user);


        $teacher =    $user->teacher;

        $teacher->update([
            'status' => 0 ,
        ]);



        if(app()->getLocale() == 'ar'){

          session()->flash('success' , 'تم تعطيل الحساب بنجاح');

          }else{

              session()->flash('success' , 'Account Deactivated Successfully');
          }

        $links = Link::all();
        $scountry = Country::findOrFail($country);
        $countries = Country::all();


        return redirect()->route('profile' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);


    }


    public function saveVideo($lang , $user , $country ,Request $request)
    {



        $user = User::find($user);


        $teacher = Teacher::findOrFail($request->lesson_id);


        if($teacher->path == NULL){

            $teacher->update([
                'path'  => $request->file('lesson')->store('teachers/videos', 'public'),
                'percent' => 0 ,
            ]);

        }else{

            Storage::disk('public')->delete($teacher->path);

            Storage::disk('public')->deleteDirectory('teachers/videos/' . $teacher->id);

            $teacher->update([
                'path'  => $request->file('lesson')->store('teachers/videos', 'public'),
                'percent' => 0 ,
            ]);
        }




        $this->disPatch(new StreamVideo($teacher));
        return $teacher;




    }

    public function show($lang ,Teacher $teacher)
    {
        return $teacher;
    }

    public function imageSave($lang , $user , $country ,Request $request)
    {

        $user = User::find($user);


        $teacher = $user->teacher;

        $request->validate([

            'image' => "required|image",

            ]);


        if($teacher->image == NULL){



            Image::make($request['image'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/teachers/' . $request['image']->hashName()) , 60);

            $teacher->update([
                'image' => $request['image']->hashName(),

            ]);

        }else{


            Storage::disk('public')->delete('/images/teachers/' . $teacher->image);


            Image::make($request['image'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/teachers/' . $request['image']->hashName()) , 60);


            $teacher->update([
                'image' => $request['image']->hashName(),

            ]);
        }




        if(app()->getLocale() == 'ar'){

            session()->flash('success' , 'تم الحفظ بنجاح');

        }else{

            session()->flash('success' , 'Data Saved Successfully');
        }



        $links = Link::all();
        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        return redirect()->route('profile' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);

    }

    public function profileUpdate($lang , $user , $country ,Request $request)
    {

        $user = User::find($user);


        $request->validate([

            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users,email," . $user->id,
            'profile' => "image",

            ]);


            if($request->hasFile('profile')){

                if($user->profile == 'avatarmale.png' || $user->profile == 'avatarfemale.png'){

                    Image::make($request['profile'])->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/images/users/' . $request['profile']->hashName()) , 60);

                }else{
                    Storage::disk('public')->delete('/images/users/' . $user->profile);

                    Image::make($request['profile'])->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/images/users/' . $request['profile']->hashName()) , 60);

                }


                $user->update([
                    'profile' => $request['profile']->hashName(),
                ]);
            }


            if($request->password == NULL){


                $user->update([
                    'name' => $request['name'],
                    'email' => $request['email'],

                ]);


            }else{
                $user->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                ]);

            }







        if(app()->getLocale() == 'ar'){

            session()->flash('success' , 'تم الحفظ بنجاح');

        }else{

            session()->flash('success' , 'Data Saved Successfully');
        }



        $links = Link::all();
        $scountry = Country::findOrFail($country);
        $countries = Country::all();

        return redirect(route('profile' , ['lang'=> app()->getLocale(), 'user'=>$user->id , 'country'=> $scountry]));

    }


}

