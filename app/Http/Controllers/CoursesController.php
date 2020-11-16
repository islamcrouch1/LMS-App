<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Country;
use App\Link;


class CoursesController extends Controller
{
    public function index($lang , $course , $scountry)
    {

        $links = Link::all();

        $scountry = Country::findOrFail($scountry);
        $course = Course::findOrFail($course);
        $countries = Country::all();
        return view('courses' , compact('course' , 'countries' , 'scountry' , 'links' ));
    }

}
