<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Order;


class AllOrdersController extends Controller
{

        public function __construct()
        {
            // $this->middleware('auth');
            $this->middleware('role:superadministrator|administrator');

            $this->middleware('permission:all_orders-read')->only('index' , 'show');
            $this->middleware('permission:all_orders-create')->only('create' , 'store');
            $this->middleware('permission:all_orders-update')->only('edit' , 'update');
            $this->middleware('permission:all_orders-delete')->only('destroy' , 'trashed');
            $this->middleware('permission:all_orders-restore')->only('restore');
        }


        public function index(Request $request)
        {

            $orders = Order::whenSearch(request()->search_order)
            ->whereHas('user', function ($q) use ($request) {

                return $q->where('name', 'like', '%' . $request->search . '%');

            })
            ->latest()
            ->paginate(5);

            return view('dashboard.all_orders.index')->with('orders' , $orders);
        }


        public function products($lang , Order $order)
        {
            $products = $order->products;
            return view('dashboard.all_orders._products', compact('order', 'products'));

        }//end of products



        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */


        public function destroy($lang , $order , Request $request)
        {

            $order = Order::withTrashed()->where('id' , $order)->first();

            if($order->trashed()){

                if(auth()->user()->hasPermission('all_orders-delete')){

                    foreach ($order->products as $product) {

                        $product->update([
                            'stock' => $product->stock + $product->pivot->quantity
                        ]);

                    }//end of for each


                    $order->forceDelete();


                    session()->flash('success' , 'order Deleted successfully');

                    $all_orders = order::onlyTrashed()->whenSearch(request()->search_order)
                    ->whereHas('user', function ($q) use ($request) {

                        return $q->where('name', 'like', '%' . $request->search . '%');

                    })
                    ->latest()
                    ->paginate(5);
                    return view('dashboard.all_orders.index' , ['orders' => $all_orders]);
                }else{
                    session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                    $all_orders = Order::onlyTrashed()->whenSearch(request()->search_order)
                    ->whereHas('user', function ($q) use ($request) {

                        return $q->where('name', 'like', '%' . $request->search . '%');

                    })
                    ->latest()
                    ->paginate(5);
                    return view('dashboard.all_orders.index' , ['orders' => $all_orders]);
                }



            }else{

                if(auth()->user()->hasPermission('all_orders-trash')){

                    $order->delete();

                    session()->flash('success' , 'order trashed successfully');

                    $all_orders = Order::whenSearch(request()->search_order)
                    ->whereHas('user', function ($q) use ($request) {

                        return $q->where('name', 'like', '%' . $request->search . '%');

                    })
                    ->latest()
                    ->paginate(5);

                    return view('dashboard.all_orders.index')->with('orders' , $all_orders);

                }else{
                    session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                    $all_orders = Order::whenSearch(request()->search_order)
                    ->whereHas('user', function ($q) use ($request) {

                        return $q->where('name', 'like', '%' . $request->search . '%');

                    })
                    ->latest()
                    ->paginate(5);

                    return view('dashboard.all_orders.index')->with('orders' , $all_orders);
                }

            }


        }


        public function trashed(Request $request)
        {

            $all_orders = Order::onlyTrashed()
            ->whenSearch(request()->search_order)
            ->whereHas('user', function ($q) use ($request) {

                return $q->where('name', 'like', '%' . $request->search . '%');

            })
            ->latest()
            ->paginate(5);;
            return view('dashboard.all_orders.index' , ['orders' => $all_orders]);

        }

        public function restore( $lang , $order ,Request $request)
        {

            $order = Order::withTrashed()->where('id' , $order)->first()->restore();

            session()->flash('success' , 'order restored successfully');

            $all_orders = Order::whenSearch(request()->search_order)
            ->whereHas('user', function ($q) use ($request) {

                return $q->where('name', 'like', '%' . $request->search . '%');

            })
            ->latest()
            ->paginate(5);

            return view('dashboard.all_orders.index')->with('orders' , $all_orders);
        }


}
