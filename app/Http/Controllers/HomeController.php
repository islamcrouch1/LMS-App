<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LearningSystem;
use App\Country;

use App\Post;
use App\Ad;
use App\Sponser;
use App\Link;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('role:user|superadministrator');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($lang , $scountry)
    {

        $ads = Ad::all();
        $links = Link::all();

        $sponsers = Sponser::all();

        $posts = Post::all();
        $scountry = Country::findOrFail($scountry);
        $learning_systems = LearningSystem::all();
        $countries = Country::all();
        return view('home' , compact('learning_systems' , 'countries' , 'scountry' , 'posts', 'ads' , 'sponsers' , 'links' ));
    }
}
