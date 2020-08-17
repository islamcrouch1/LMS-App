<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lesson;
use App\Country;

class LessonsController extends Controller
{
    public function index($lang , $lesson , $scountry)
    {

        $scountry = Country::findOrFail($scountry);        
        $lesson = Lesson::findOrFail($lesson);
        $countries = Country::all();
        return view('lessons' , compact('lesson' , 'countries' , 'scountry' ));
    }
}
