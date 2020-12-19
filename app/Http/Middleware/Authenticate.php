<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use App\Country;
use App\Link;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $links = Link::all();
        $scountry = Country::findOrFail($request->country);
        $countries = Country::all();


        if (! $request->expectsJson()) {
            return route('login', ['lang'=> $request->lang , 'country'=> $scountry]);
        }
    }
}
