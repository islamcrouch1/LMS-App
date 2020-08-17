<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class WelcomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');
        
    }
    public function index()
    {

        
        return view('dashboard.welcome')->with('usersCount');
    }
}
