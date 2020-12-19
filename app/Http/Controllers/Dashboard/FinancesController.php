<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\User;
use App\Role;
use App\Country;
use App\Cart;
use App\CourseOrder;
use App\HomeWorkOrder;
use App\Order;

use App\Notification;

use App\Events\NewNotification;

use Carbon\Traits\Timestamp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class FinancesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:finances-read')->only('index' , 'show');
        $this->middleware('permission:finances-create')->only('create' , 'store');
        $this->middleware('permission:finances-update')->only('edit' , 'update');
        $this->middleware('permission:finances-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:finances-restore')->only('restore');
    }


    public function index()
    {
        $orders = Order::all();
        $countries = Country::all();

        $HomeworksOrders = HomeWorkOrder::all();

        $coursesOrdres = CourseOrder::all();


        return view('dashboard.finances.index' , compact('orders' , 'countries' , 'HomeworksOrders' , 'coursesOrdres'));
    }
}
