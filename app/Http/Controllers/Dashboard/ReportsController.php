<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Country;
use App\Cart;
use App\Report;
use App\CourseOrder;
use App\HomeWorkOrder;

use App\Notification;

use App\Events\NewNotification;

use Carbon\Traits\Timestamp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;

class ReportsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:reports-read')->only('index' , 'show');
        $this->middleware('permission:reports-create')->only('create' , 'store');
        $this->middleware('permission:reports-update')->only('edit' , 'update');
        $this->middleware('permission:reports-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:reports-restore')->only('restore');
    }


    public function index()
    {
        $countries = Country::all();
        $reports = Report::whenSearch(request()->search)
        ->whenCountry(request()->country_id)
        ->paginate(5);


        return view('dashboard.reports.index' , compact('reports' , 'countries'));
    }
}
