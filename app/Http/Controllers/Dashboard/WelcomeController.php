<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Order;
use App\Product;
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


        $categories_count = Category::count();
        $products_count = Product::count();
        $users_count = User::count() - 1 ;
        $orders_count = Order::count();

        return view('dashboard.welcome', compact('categories_count', 'products_count', 'users_count', 'orders_count'));
    }
}
