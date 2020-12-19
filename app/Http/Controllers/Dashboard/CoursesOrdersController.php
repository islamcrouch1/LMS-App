<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Country;
use App\Cart;
use App\Teacher;
use App\CourseOrder;
use App\Withdraw;

use App\Notification;

use App\Events\NewNotification;

use Carbon\Traits\Timestamp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class CoursesOrdersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:courses_orders-read')->only('index' , 'show');
        $this->middleware('permission:courses_orders-create')->only('create' , 'store');
        $this->middleware('permission:courses_orders-update')->only('edit' , 'update');
        $this->middleware('permission:courses_orders-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:courses_orders-restore')->only('restore');
    }


    public function index()
    {
        $countries = Country::all();
        $courses_orders = CourseOrder::whenSearch(request()->search)
        ->whenCountry(request()->country_id)
        ->whenStatus(request()->status)
        ->paginate(5);


        return view('dashboard.courses_orders.index' , compact('courses_orders' , 'countries'));
    }
}
