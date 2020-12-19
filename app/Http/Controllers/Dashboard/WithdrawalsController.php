<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Country;
use App\Cart;
use App\Teacher;
use App\BankInformation;
use App\Withdraw;

use App\Notification;

use App\Events\NewNotification;

use Carbon\Traits\Timestamp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class WithdrawalsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:withdrawals-read')->only('index' , 'show');
        $this->middleware('permission:withdrawals-create')->only('create' , 'store');
        $this->middleware('permission:withdrawals-update')->only('edit' , 'update');
        $this->middleware('permission:withdrawals-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:withdrawals-restore')->only('restore');
    }


    public function index()
    {
        $countries = Country::all();
        $withdrawals = Withdraw::whenSearch(request()->search)
        ->whenCountry(request()->country_id)
        ->whenStatus(request()->status)
        ->paginate(5);


        return view('dashboard.withdrawals.index' , compact('withdrawals' , 'countries'));
    }



    public function update($lang ,Request $request, Withdraw $withdrawal)
    {
        $request->validate([

            'status' => "required|string|max:255",

            ]);



            $withdrawal->update([
                'status' => $request->status,
            ]);


            switch($withdrawal->status){
                case('waiting'):

                        $status_ar = 'في انتظار المراجعة من الإدارة';
                        $status_en = 'Awaiting review from management';

                break;
                case('done'):
                        $status_ar = 'تم ايداع المبلغ في حسابك';
                        $status_en = 'The amount has been deposited into your account';

                break;
                case('recieved'):
                        $status_ar = 'تم استلام طلبك ويتم مراجعته لايداع المبلغ';
                        $status_en = 'Your request has been received and is being reviewed for a deposit';

                break;

            }


            $title_ar = 'اشعار من الإدارة';
            $body_ar = 'لقد تم تغيير حالة طلب سحب الرصيد الخاصة بك الى ' . $status_ar ;
            $title_en = 'Notification From Admin';
            $body_en  = 'The status of your withdrawal request has changed to ' . $status_en;


        $notification = Notification::create([
            'user_id' => $withdrawal->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar ,
            'title_en' => $title_en,
            'body_en' => $body_en ,
            'date' => $withdrawal->updated_at,
            'url' =>  route('finances' , ['lang'=>app()->getLocale() , 'user'=>$withdrawal->user->id ,  'country'=>$withdrawal->user->country->id]),
        ]);



        $data =[
            'notification_id' => $notification->id,
            'user_id' => $withdrawal->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar ,
            'title_en' => $title_en,
            'body_en' => $body_en ,
            'date' => $withdrawal->updated_at->format('Y-m-d H:i:s'),
            'status'=> $notification->status,
            'url' =>  route('finances' , ['lang'=>app()->getLocale() , 'user'=>$withdrawal->user->id ,  'country'=>$withdrawal->user->country->id]),
            'change_status' => route('notification-change', ['lang'=>app()->getLocale() , 'user'=>$withdrawal->user->id  , 'country'=>$withdrawal->user->country->id , 'notification'=>$notification->id]),

       ];


       event(new NewNotification($data));

            if(app()->getLocale() == 'ar'){
                session()->flash('success' , 'تم تحديث حالة الطلب بنجاح');

            }else{
                session()->flash('success' , 'request updated successfully');

            }


            return redirect()->route('withdrawals.index' , app()->getLocale());

    }


}
