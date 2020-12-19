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
use App\HomeWorkOrder;

use App\Notification;

use App\Events\NewNotification;

use Carbon\Traits\Timestamp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class HomeworksOrdersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:homeworks_orders-read')->only('index' , 'show');
        $this->middleware('permission:homeworks_orders-create')->only('create' , 'store');
        $this->middleware('permission:homeworks_orders-update')->only('edit' , 'update');
        $this->middleware('permission:homeworks_orders-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:homeworks_orders-restore')->only('restore');
    }


    public function index()
    {
        $countries = Country::all();
        $homeworks_orders = HomeWorkOrder::whenSearch(request()->search)
        ->whenCountry(request()->country_id)
        ->whenStatus(request()->status)
        ->paginate(5);


        return view('dashboard.homeworks_orders.index' , compact('homeworks_orders' , 'countries'));
    }
}
