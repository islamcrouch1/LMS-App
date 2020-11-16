<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Category;
use App\Product;

use Illuminate\Http\Request;



class OrdersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:orders-read')->only('index' , 'show');
        $this->middleware('permission:orders-create')->only('create' , 'store');
        $this->middleware('permission:orders-update')->only('edit' , 'update');
        $this->middleware('permission:orders-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:orders-restore')->only('restore');
    }


    public function index()
    {
        $orders = Order::whenSearch(request()->search)
        ->latest()
        ->paginate(5);

        return view('dashboard.orders.index')->with('orders' , $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang ,Request $request)
    {

        $user = User::find($request->user);


        $categories = Category::with('products')->get();

        $orders = $user->orders()->with('products')->paginate(5);



        return view('dashboard.orders.create' , compact('user' , 'categories' , 'orders'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($lang , Request $request)
    {

        $user = User::find($request->user);


        $request->validate([
            'products' => 'required|array',
        ]);

        $this->attach_order($request, $user);




            session()->flash('success' , 'order created successfully');



            $orders = Order::whenSearch(request()->search)
            ->whereHas('user', function ($q) use ($request) {

                return $q->where('name', 'like', '%' . $request->search . '%');

            })
            ->latest()
            ->paginate(5);

            return view('dashboard.all_orders.index')->with('orders' , $orders);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang , Order $order , Request $request)
    {


        $user = User::find($request->user);

        $categories = Category::with('products')->get();

        $orders = $user->orders()->with('products')->paginate(5);

        return view('dashboard.orders.edit' , compact('user' , 'categories' , 'order' , 'orders'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, order $order )
    {


        $user = User::find($request->user);



        $request->validate([
            'products' => 'required|array',
            'address_id' => 'required|string',
        ]);

        $this->detach_order($order);

        $this->attach_order($request, $user);


            session()->flash('success' , 'order updated successfully');



            $orders = Order::whenSearch(request()->search)
            ->whereHas('user', function ($q) use ($request) {

                return $q->where('name', 'like', '%' . $request->search . '%');

            })
            ->latest()
            ->paginate(5);

            return view('dashboard.all_orders.index')->with('orders' , $orders);


    }





    private function attach_order($request, $user)
    {
        $order = $user->orders()->create([
            'total_price' => 0 ,
            'address_id' => $request->address_id
        ]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id => $quantity) {

            $product = Product::FindOrFail($id);
            $total_price += $product->sale_price * $quantity['quantity'];

            $product->update([
                'stock' => $product->stock - $quantity['quantity']
            ]);

        }//end of foreach

        $order->update([
            'total_price' => $total_price
        ]);

    }//end of attach order

    private function detach_order($order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);

        }//end of for each

        $order->forceDelete();

    }//end of detach order
}
