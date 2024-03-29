@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Finances')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('Finances')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{__('Finances')}}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body p-0">



                <div class="row">
                    <div class="col-md-12">
                      <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">

                            @foreach ($countries as $country)

                                <li class="nav-item">
                                    <a class="nav-link {{$loop->first ? 'active' : ''}}" id="custom-tabs-one-home-tab-{{$country->id}}" data-toggle="pill" href="#custom-tabs-one-home-{{$country->id}}" role="tab" aria-controls="custom-tabs-one-home-{{$country->id}}" aria-selected="true">{{app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en}}</a>
                                </li>

                            @endforeach


                          </ul>
                        </div>
                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-one-tabContent">

                            @foreach ($countries as $country)

                            <div class="tab-pane fade show {{$loop->first ? 'active' : ''}}" id="custom-tabs-one-home-{{$country->id}}" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab-{{$country->id}}">

                                <div class="row p-5">
                                    <div class="col-md-12">
                                        <h3>{{__('Library')}}</h3>
                                    </div>
                                </div>
                                <div class="row">
                                        @php
                                            $total_sales = 0;
                                            $all_order_p_price = 0;
                                            $order_p_price = 0;
                                            $profits = 0;
                                        @endphp
                                        @foreach ($country->orders as $order)
                                        @if ($order->payment_status == 'done')
                                        @php
                                            $total_sales = $total_sales + $order->total_price + $order->wallet_balance;
                                        @endphp
                                        @endif
                                            @foreach ($order->products as $product)
                                            @if ($order->payment_status == 'done')
                                            @php

                                                $order_p_price = $order_p_price + ($product->purchase_price * $product->pivot->quantity);
                                                $all_order_p_price = $all_order_p_price + $order_p_price;
                                                $order_p_price = 0;

                                            @endphp
                                            @endif
                                            @endforeach
                                        @endforeach
                                        @php
                                            $profits = $total_sales - $all_order_p_price ;
                                        @endphp
                                    <div class="col-lg-4">
                                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                            <div class="card-body">
                                                <h4 class="h2 mb-0">{{ $total_sales . ' ' . $country->currency }}</h4>
                                                <div>{{__('Total sales')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card text-center mb-lg-0">
                                            <div class="card-body">
                                                <h4 class="h2 mb-0">{{ $profits . ' ' . $country->currency }}</h4>
                                                <div>{{__('Profits')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-5">
                                    <div class="col-md-12">
                                        <h3>{{__('Courses')}}</h3>
                                    </div>
                                </div>

                                <div class="row">
                                    @php
                                        $total_sales = 0;
                                    @endphp
                                    @foreach ($country->courses_orders as $order)
                                    @if ($order->status == 'done')
                                    @php
                                        $total_sales = $total_sales + $order->total_price + $order->wallet_balance;
                                    @endphp
                                    @endif
                                    @endforeach
                                    <div class="col-lg-4">
                                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                            <div class="card-body">
                                                <h4 class="h2 mb-0">{{ $total_sales . ' ' . $country->currency }}</h4>
                                                <div>{{__('Total sales')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                    $total_sales_course = 0;
                                    @endphp
                                    @foreach ($country->courses as $course)
                                        @foreach ($course->course_orders as $order)
                                            @if ($order->status == 'done')
                                            @php
                                                $total_sales_course = $total_sales_course + $order->total_price + $order->wallet_balance;
                                            @endphp
                                            @endif
                                        @endforeach
                                        <div class="col-lg-4 mb-2">
                                            <div class="card text-center mb-lg-0">
                                                <div class="card-body">
                                                    <h4 class="h2 mb-0">{{ $total_sales_course . ' ' . $country->currency }}</h4>
                                                    <div>{{__('Profits for ')}} {{ app()->getLocale() == 'ar' ? $course->name_ar . ' ' . $course->ed_class->name_ar : $course->name_en . ' ' . $course->ed_class->name_ar}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $total_sales_course = 0;
                                        @endphp
                                    @endforeach
                                </div>


                                <div class="row p-5">
                                    <div class="col-md-12">
                                        <h3>{{__('Homeworks Orders')}}</h3>
                                    </div>
                                </div>

                                <div class="row">


                                    @php

                                        $total_homework_sales = 0;
                                        $total_homework_teacher_commision = 0;

                                        $OutstandingBalance = 0 ;
                                        $countH = 0 ;
                                        $balanceCount = 0;
                                        $balance = 0 ;
                                        $amount = 0;
                                        $teachers_profits = 0;
                                        $withdraw_done = 0;
                                        $withdraw_hold = 0;

                                    @endphp

                                    @foreach ($country->withdraws as $withdraw)
                                    @if ($withdraw->status == 'done')
                                        @php
                                            $withdraw_done = $withdraw_done + $withdraw->amount ;
                                        @endphp
                                    @else
                                        @php
                                            $withdraw_hold = $withdraw_hold + $withdraw->amount ;
                                        @endphp
                                    @endif
                                    @php
                                        $amount = $amount + $withdraw->amount
                                    @endphp
                                    @endforeach



                                    @foreach ($country->homeworks_orders as $homework_order)

                                    @if ($homework_order->status == 'done'  || $homework_order->status == 'canceled')

                                        @php

                                            $waiting_count = 0 ;
                                            $rejected_count = 0 ;
                                            $done_count = 0 ;
                                            $order_requests_count = 0 ;
                                            $homework_services_price = 0;
                                            $homework_services_teacher_commision = 0;


                                            $balanceCount = 0;
                                            $countH = 0;
                                            $commision = 0;
                                            $profits = 0;
                                            $total_profits = 0;

                                            foreach ($homework_order->homework_services as $homework_services) {

                                                $homework_services_price += $homework_services->price;
                                                $homework_services_teacher_commision += $homework_services->teacher_commission;

                                            }


                                            foreach ($homework_order->home_works as $homework_request) {

                                                if ($homework_request->status == 'rejected'){

                                                    $rejected_count = $rejected_count + 1 ;

                                                }


                                                if ($homework_request->status == 'waiting'){

                                                    $waiting_count = $waiting_count + 1 ;

                                                }

                                                if ($homework_request->status == 'done'){

                                                    $done_count = $done_count + 1 ;

                                                }

                                            }




                                            $order_requests_count = $homework_order->quantity + $homework_order->home_works->count() - $rejected_count;



                                            if($homework_order->status == 'canceled'){

                                                $total_homework_sales +=  ( ($order_requests_count - $homework_order->quantity ) *  $homework_order->course->homework_price ) + ( ($order_requests_count - $homework_order->quantity ) *  $homework_services_price);
                                                $total_homework_teacher_commision +=  ( ($order_requests_count - $homework_order->quantity ) *  $homework_order->course->teacher_commission ) + ( ($order_requests_count - $homework_order->quantity ) *  $homework_services_teacher_commision);
                                                $commision = (( $order_requests_count - $homework_order->quantity - $done_count ) * $homework_order->course->teacher_commission) + (( $order_requests_count - $homework_order->quantity - $done_count ) * $homework_services_teacher_commision);
                                                $OutstandingBalance = $OutstandingBalance + $commision ;


                                            }else{

                                                $total_homework_sales += ( ($order_requests_count ) *  $homework_order->course->homework_price ) + ( ($order_requests_count) *  $homework_services_price);
                                                $total_homework_teacher_commision +=  ( ($order_requests_count) *  $homework_order->course->teacher_commission ) + ( ($order_requests_count) *  $homework_services_teacher_commision);
                                                $commision = (($order_requests_count - $done_count ) * $homework_order->course->teacher_commission) + (($order_requests_count - $done_count ) * $homework_services_teacher_commision );
                                                $OutstandingBalance = $OutstandingBalance + $commision ;


                                            }

                                        @endphp

                                    @endif
                                    @endforeach

                                    <div class="col-lg-4 mb-2">
                                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                            <div class="card-body">
                                                <h4 class="h2 mb-0">{{ $total_homework_sales . ' ' . $country->currency }}</h4>
                                                <div>{{__('Total sales')}}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mb-2">
                                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                            <div class="card-body">
                                                <h4 class="h2 mb-0">{{ $total_homework_sales - $total_homework_teacher_commision }}{{' ' . $country->currency }}</h4>
                                                <div>{{__('Profits')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                            <div class="card-body">
                                                <h4 class="h2 mb-0">{{ $total_homework_teacher_commision}} {{' ' . $country->currency }}</h4>
                                                <div>{{__('Profits For Teachers')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                            <div class="card-body">
                                                <h4 class="h2 mb-0">{{ $amount}} {{' ' . $country->currency }}</h4>
                                                <div>{{__('Total balance withdrawal requests')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                            <div class="card-body">
                                                <h4 class="h2 mb-0">{{ $withdraw_hold}} {{' ' . $country->currency }}</h4>
                                                <div>{{__('Pending balance withdrawal requests')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                            <div class="card-body">
                                                <h4 class="h2 mb-0">{{ $withdraw_done}} {{' ' . $country->currency }}</h4>
                                                <div>{{__('Balance withdrawal requests that have been paid')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                            <div class="card-body">
                                                <h4 class="h2 mb-0">{{ $OutstandingBalance}} {{' ' . $country->currency }}</h4>
                                                <div>{{__('Outstanding Profits for Teachers')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                            <div class="card-body">
                                                <h4 class="h2 mb-0">{{ $total_homework_teacher_commision - $OutstandingBalance }} {{' ' . $country->currency }}</h4>
                                                <div>{{__('Teachers profits not outstanding')}}</div>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                            </div>

                            @endforeach


                          </div>
                        </div>
                        <!-- /.card -->
                      </div>
                    </div>
                </div>


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->




  @endsection

