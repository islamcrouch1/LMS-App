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

use App\Withdraw;



use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;


class FinancesController extends Controller
{
    public function index($lang , $user , $country)
    {


        $links = Link::all();
        $user = User::find($user);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();


        $orders = HomeWorkOrder::where('teacher_id' , $user->id)->get();


        return view('finances' , compact('countries' , 'scountry' , 'user'  , 'links' , 'orders' ));


    }

    public function bankInformation($lang , $user , $country , Request $request)
    {

        $request->validate([

            'full_name' => "required|string",
            'bank_name' => "required|string",
            'bank_account_number' => "required|string",
            'image1' => "image",
            'image2' => "image",
            ]);





            $links = Link::all();
            $user = User::find($user);


            $scountry = Country::findOrFail($user->country_id);
            $countries = Country::all();



            if($request->hasFile('image1')){



                Image::make($request['image1'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/bankinformation/' . $request['image1']->hashName()) , 60);

                $image1 = $request['image1']->hashName();

            }else{
                if($user->bank_information->image1 == Null){

                    if(app()->getLocale() == 'ar'){

                        session()->flash('success' , 'عزيز المعلم يرجى ارفاق صورة البطاقة الشخصية لكي يتم حفظ معلوماتك البنكية');

                    }else{

                        session()->flash('success' , 'You Should Upload Your ID Images');
                    }

                    return redirect()->route('finances' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);

                }else{
                    $image1 = $user->bank_information->image1;
                }


            }


            if($request->hasFile('image2')){

                Image::make($request['image2'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/bankinformation/' . $request['image2']->hashName()) , 60);

                $image2 = $request['image2']->hashName();

            }else{
                if($user->bank_information->image2 == Null){

                    if(app()->getLocale() == 'ar'){

                        session()->flash('success' , 'عزيز المعلم يرجى ارفاق صورة البطاقة الشخصية لكي يتم حفظ معلوماتك البنكية');

                    }else{

                        session()->flash('success' , 'You Should Upload Your ID Images');
                    }

                    return redirect()->route('finances' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);

                }else{
                    $image2 = $user->bank_information->image2;
                }
            }



            $user->bank_information->update([

                'full_name' => $request['full_name'],
                'bank_name' => $request['bank_name'],
                'bank_account_number' => $request['bank_account_number'],
                'image1' => $image1,
                'image2' => $image2,

            ]);



            if(app()->getLocale() == 'ar'){

                session()->flash('success' , 'تم حفظ البيانات بنجاح');

            }else{

                session()->flash('success' , 'Data Saved Successfully');
            }

            return redirect()->route('finances' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);

    }


    public function withdraw($lang , $user , $country , Request $request)
    {


        $request->validate([

            'amount' => "required|integer",
            ]);


            $links = Link::all();
            $user = User::find($user);


            $scountry = Country::findOrFail($user->country_id);
            $countries = Country::all();

            $bankinformation = $user->bank_information;


            $orders = HomeWorkOrder::where('teacher_id' , $user->id)->get();


            if($request->amount <= 0){

                if(app()->getLocale() == 'ar'){

                    session()->flash('success' , 'لم يمكنك عمل طلب سحب الرصيد ، رصيدك لا يسمح');

                }else{

                    session()->flash('success' , 'You cannot make a request to withdraw the balance, your balance is not allowed');
                }

                return redirect()->route('finances' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);

            }elseif($bankinformation->full_name == null || $bankinformation->bank_name == null || $bankinformation->bank_account_number == null || $bankinformation->image1 == null || $bankinformation->image2 == null){

                if(app()->getLocale() == 'ar'){

                    session()->flash('success' , 'عزيزي المعلم يرجى اكمال بيانات حسابك البنكية بشكل كامل كي تستطيع من عمل طلب سحب رصيدك' );

                }else{

                    session()->flash('success' , 'Dear teacher, please complete your bank account information completely so that you can make a request to withdraw your balance');
                }

                return redirect()->route('finances' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);

            }else{

                $withdraw = Withdraw::create([
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                    'status' => 'waiting',
                    'code' => 123456,
                    'country_id' => $scountry->id,
                    'user_name' => $user->name,
                ]);



                if(app()->getLocale() == 'ar'){

                    session()->flash('success' , 'تم ارسال الطلب بنجاح وسوف يتم مراجعته من الإدارة' );

                }else{

                    session()->flash('success' , 'The request has been sent successfully and it will be reviewed by the administration');
                }

                return redirect()->route('finances' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id]);
            }


    }

}



