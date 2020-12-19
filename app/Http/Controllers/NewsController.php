<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;

use App\Post;
use App\Link;

class NewsController extends Controller
{
    public function index($lang , $scountry)
    {


        $links = Link::all();

        $scountry = Country::findOrFail($scountry);
        $posts = Post::where('country_id' , $scountry->id)->orderBy('id', 'desc')->paginate(9);

        $countries = Country::all();

        return view('news' , compact('countries' , 'scountry' , 'posts', 'links' ));
    }


    public function post($lang , $post , $scountry )
    {


        $links = Link::all();

        $scountry = Country::findOrFail($scountry);


        $post = Post::findOrFail($post);

        $countries = Country::all();

        return view('news-show' , compact('countries' , 'scountry' , 'post', 'links' ));
    }

}
