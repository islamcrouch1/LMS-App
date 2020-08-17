<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Country;

class CoursesController extends Controller
{
    public function index($lang , $course , $scountry)
    {

        $scountry = Country::findOrFail($scountry);        
        $course = Course::findOrFail($course);
        $countries = Country::all();
        return view('courses' , compact('course' , 'countries' , 'scountry' ));
    }

}
