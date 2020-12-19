<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class NotificationController extends Controller
{


    public function changeStatus ($lang , $user , $country , Request $request)
    {


        $notification = Notification::findOrFail($request->notification);


        if($notification->status == 0){

            $notification->update([
                'status' => 1 ,
            ]);

        }
    }


}
