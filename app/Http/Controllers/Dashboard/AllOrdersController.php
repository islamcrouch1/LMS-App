<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Order;
use App\User;
use App\Country;



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


            $countries = Country::all();

            $orders = Order::whenSearch(request()->search_order)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->latest()
            ->paginate(5);



            return view('dashboard.all_orders.index')->with('orders' , $orders)->with('countries' , $countries);
        }


        public function products($lang , Order $order , Request $request)
        {

            $user = User::find($request->user);

            $products = $order->products;
            return view('dashboard.all_orders._products', compact('order', 'products' , 'user'));

        }//end of products



        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */


        public function destroy($lang , $order , Request $request)
        {

            $countries = Country::all();
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
                    ->whenCountry(request()->country_id)
                    ->whenStatus(request()->status)
                    ->whenPaymentStatus(request()->payment_status)
                    ->latest()
                    ->paginate(5);
                    return view('dashboard.all_orders.index' , ['orders' => $all_orders])->with('countries' , $countries);
                }else{
                    session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                    $all_orders = Order::onlyTrashed()->whenSearch(request()->search_order)
                    ->whenCountry(request()->country_id)
                    ->whenStatus(request()->status)
                    ->whenPaymentStatus(request()->payment_status)
                    ->paginate(5);
                    return view('dashboard.all_orders.index' , ['orders' => $all_orders])->with('countries' , $countries);
                }



            }else{

                if(auth()->user()->hasPermission('all_orders-trash')){

                    $order->delete();

                    session()->flash('success' , 'order trashed successfully');

                   return redirect()->route('all_orders.index' , app()->getLocale());

                }else{
                    session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                    return redirect()->route('all_orders.index' , app()->getLocale());

                }

            }


        }


        public function trashed(Request $request)
        {

            $countries = Country::all();

            $all_orders = Order::onlyTrashed()
            ->whenSearch(request()->search_order)
            ->whenCountry(request()->country_id)
            ->whenPaymentStatus(request()->payment_status)
            ->whenStatus(request()->status)
            ->paginate(5);;
            return view('dashboard.all_orders.index' , ['orders' => $all_orders])->with('countries' , $countries);

        }

        public function restore( $lang , $order ,Request $request)
        {

            $order = Order::withTrashed()->where('id' , $order)->first()->restore();

            session()->flash('success' , 'order restored successfully');
            return redirect()->route('all_orders.index' , app()->getLocale());

        }


}



            // ->whereHas('user', function ($q) use ($request) {

            //     return $q->where('name', 'like', '%' . $request->search . '%');

            // })
            // ->latest()
            // ->paginate(5);
