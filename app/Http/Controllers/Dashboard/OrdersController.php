<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Category;
use App\Product;

use App\Notification;

use App\Events\NewNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ->whenCountry(request()->country_id)
        ->whenStatus(request()->status)
        ->whenPaymentStatus(request()->payment_status)
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


        $categories = Category::where('country_id' , $user->country->id)->with('products')->get();

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
            'address_id' => 'required|string',
            'status' => 'required|string',
        ]);

        $this->attach_order($request, $user);

            session()->flash('success' , 'order created successfully');

            return redirect()->route('all_orders.index' , app()->getLocale());

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
            'status' => 'required|string',
        ]);

        $this->detach_order($order);

        $this->attach_order($request, $user);


            session()->flash('success' , 'order updated successfully');



            return redirect()->route('all_orders.index' , app()->getLocale());



    }





    private function attach_order($request, $user)
    {

        $orderid = time().rand(999,9999) ;

        $order = $user->orders()->create([
            'total_price' => 0 ,
            'address_id' => $request->address_id ,
            'status' => $request->status,
            'orderid' => $orderid ,
            'payment_status' => 'done',
            'country_id'=>$user->country->id,
            'user_name'=>$user->name,
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


    public function updateStatus($lang ,Request $request, Order $order)
    {



        $request->validate([

            'status' => "required|string|max:255",

            ]);




            $order->update([
                'status' => $request->status,
            ]);


            switch($order->status){
                case('recieved'):

                        $status_ar = 'في انتظار المراجعة من الإدارة';
                        $status_en = 'Awaiting review from management';

                break;
                case('processing'):
                        $status_ar = 'طلبك قيد المراجعة';
                        $status_en = 'Your order is under review';

                break;
                case('shipped'):
                        $status_ar = 'تم شحن طلبك بنجاح';
                        $status_en = 'Your order has been shipped';

                break;
                case('completed'):
                    $status_ar = 'لقد قمت باستلام طلبك بنجاح';
                    $status_en = 'You have successfully received your request';

                break;

            }





            $title_ar = 'اشعار من الإدارة';
            $body_ar = 'لقد تم تغيير حالة طلبك من المكتبة الى ' . $status_ar ;
            $title_en = 'Notification From Admin';
            $body_en  = 'The status of your library order has changed to ' . $status_en;


        $notification = Notification::create([
            'user_id' => $order->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar ,
            'title_en' => $title_en,
            'body_en' => $body_en ,
            'date' => $order->updated_at,
            'url' =>  route('my-orders' , ['lang'=>app()->getLocale() , 'user'=>$order->user->id ,  'country'=>$order->user->country->id]),
        ]);



        $data =[
            'notification_id' => $notification->id,
            'user_id' => $order->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar ,
            'title_en' => $title_en,
            'body_en' => $body_en ,
            'date' => $order->updated_at->format('Y-m-d H:i:s'),
            'status'=> $notification->status,
            'url' =>  route('my-orders' , ['lang'=>app()->getLocale() , 'user'=>$order->user->id ,  'country'=>$order->user->country->id]),
            'change_status' => route('notification-change', ['lang'=>app()->getLocale() , 'user'=>$order->user->id  , 'country'=>$order->user->country->id , 'notification'=>$notification->id]),

       ];


       event(new NewNotification($data));

            if(app()->getLocale() == 'ar'){
                session()->flash('success' , 'تم تحديث حالة الطلب بنجاح');

            }else{
                session()->flash('success' , 'request updated successfully');

            }


            return redirect()->route('all_orders.index' , app()->getLocale());

    }


}
