<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lesson;
use App\Country;
use App\Link;



class LessonsController extends Controller
{
    public function index($lang , $lesson , $scountry)
    {

        $links = Link::all();

        $scountry = Country::findOrFail($scountry);
        $lesson = Lesson::findOrFail($lesson);
        $countries = Country::all();
        return view('lessons' , compact('lesson' , 'countries' , 'scountry' , 'links' ));
    }
}
