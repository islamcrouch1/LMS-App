<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LearningSystem;
use App\Country;
use App\Link;


class LearningSystemsController extends Controller
{
    public function index($lang , $learning_system , $scountry)
    {

        $links = Link::all();
        $scountry = Country::findOrFail($scountry);
        $learning_system = LearningSystem::findOrFail($learning_system);
        $countries = Country::all();
        return view('learning_systems' , compact('learning_system' , 'countries' , 'scountry' , 'links' ));
    }
}
