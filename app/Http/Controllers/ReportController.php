<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Course;
use App\HomeWork;
use App\Link;
use App\User;
use App\Jobs\StreamVideo;
use App\Report;

use App\Withdraw;



use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class ReportController extends Controller
{
    public function create($lang , $user , $country)
    {


        $links = Link::all();
        $user = User::find($user);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();


        return view('report' , compact('countries' , 'scountry' , 'user'  , 'links' ));


    }


    public function index($lang , $user , $country)
    {


        $links = Link::all();
        $user = User::find($user);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();


        return view('report-done' , compact('countries' , 'scountry' , 'user'  , 'links' ));


    }


    public function store($lang , $user , $country , Request $request)
    {


        $request->validate([

            'details' => "string",
            'report_file' => "nullable|file",
            'report_image' => "nullable|image",
            'service' => "required|string"
            ]);





        $links = Link::all();
        $user = User::find($user);

        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();




            if($request->hasFile('report_image')){

                Image::make($request['report_image'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/reports/' . $request['report_image']->hashName()) , 60);

                $image = $request['report_image']->hashName();

            }else{
                $image = '#';
            }


            if($request->hasFile('report_file')){


                $fileName = time(). '-' . '.'.$request['report_file']->extension();

                $request['report_file']->move(public_path('storage/reports/files'), $fileName);
            }else{
                $fileName = '#';
            }




            $report = Report::create([
                'user_id' => $user->id,
                'user_name'=>$user->name,
                'country_id'=>$user->country->id,
                'service'=> $request['service'],
                'details' => $request['details'],
                'report_image' => $image,
                'report_file' => $fileName,

            ]);


            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'تم ارسال طلبك بنجاح');

            }else{

                session()->flash('success' , 'Requset Sent Successfully');
            }


            return redirect()->route('report-done' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);


    }

}
