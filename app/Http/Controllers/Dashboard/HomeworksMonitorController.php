<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Country;
use App\Cart;
use App\Teacher;
use App\HomeWork;
use App\Course;

use App\Notification;

use App\Events\NewNotification;

use Carbon\Traits\Timestamp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class HomeworksMonitorController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:homeworks_monitor-read')->only('index' , 'show');
        $this->middleware('permission:homeworks_monitor-create')->only('create' , 'store');
        $this->middleware('permission:homeworks_monitor-update')->only('edit' , 'update');
        $this->middleware('permission:homeworks_monitor-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:homeworks_monitor-restore')->only('restore');
    }


    public function index()
    {
        $courses = Course::all();
        $countries = Country::all();
        $requests = HomeWork::whenSearch(request()->search)
        ->whenCountry(request()->country_id)
        ->whenCourse(request()->course_id)
        ->whenStatus(request()->status)
        ->paginate(5);


        return view('dashboard.homeworks_monitor.index' , compact('requests' , 'countries' , 'courses'));
    }
}
