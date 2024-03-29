@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Homeworks Orders')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('Homeworks Orders')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

      <div class="row">
        <div class="col-md-12">
          <form action="">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                <input type="text" name="search" autofocus placeholder="{{__('Search By Teacher Name Or Student Name ..')}}" class="form-control" value="{{request()->search}}">
                </div>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="country_id" style="display:inline-block">
                  <option value="" selected>{{__('All Countries')}}</option>
                  @foreach ($countries as $country)
                  <option value="{{$country->id}}" {{ request()->country_id == $country->id ? 'selected' : ''}}>{{app()->getLocale() == 'ar' ?  $country->name_ar : $country->name_en}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="status" style="display:inline-block">
                  <option value="" selected>{{__('All Status')}}</option>
                    <option value="waiting" {{request()->status == 'waiting' ? 'selected' : ''}}>{{__('Waiting for payment')}}</option>
                    <option value="done" {{request()->status == 'done' ? 'selected' : ''}}>{{__('Payment Done')}}</option>
                    <option value="canceled" {{request()->status == 'canceled' ? 'selected' : ''}}>{{__('the request has been canceled')}}</option>
                </select>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
                {{-- @if (auth()->homeworks_order()->hasPermission('homeworks_orders-create'))
                <a href="{{route('homeworks_orders.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">{{__('Create homeworks_order')}}</button></a>
                @else
                <a href="#" disabled> <button type="button" class="btn btn-primary">{{__('Create homeworks_order')}}</button></a>
                @endif --}}
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">{{__('Homeworks Orders')}}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($homeworks_orders->count() > 0)
          <table class="table table-striped projects">
              <thead>

                  <tr>

                    <th class="text-center">#id</th>
                    <th class="text-center">{{__('Profile')}}</th>
                    <th class="text-center">{{__('Teacher Name')}}</th>
                    <th class="text-center">{{__('Student Name')}}</th>
                    <th class="text-center">{{__('Course')}}</th>
                    <th class="text-center">{{__('Paid Amount')}}</th>
                    <th class="text-center">{{__('Wallet Balance')}}</th>
                    <th class="text-center">{{__('Quantity')}}</th>
                    <th class="text-center">{{__('Status')}}</th>
                    <th class="text-center">{{__('Order Date')}}</th>

                  </tr>

              </thead>

              <tbody>

                  <tr>

                    @foreach ($homeworks_orders->reverse() as $homeworks_order)
                    @php
                    $teacher = App\User::find($homeworks_order->teacher_id);
                    @endphp
                    <td  class="text-center">{{ $homeworks_order->id }}</td>
                    <td  class="text-center"><img alt="Avatar" class="table-avatar" src="{{ asset('storage/images/users/' . $teacher->profile) }}"></td>
                    <td  class="text-center"><small><a href="{{route('users.show' , [app()->getLocale() , $teacher->id])}}">
                        {{ $homeworks_order->teacher_name }}
                    </a></small></td>
                    <td  class="text-center"><small><a href="{{route('users.show' , [app()->getLocale() , $homeworks_order->user->id])}}">
                        {{ $homeworks_order->user->name }}
                    </a></small></td>
                    <td>
                        {{ app()->getLocale() == 'ar' ? $homeworks_order->course->name_ar . ' - ' . $homeworks_order->course->ed_class->name_ar : $homeworks_order->course->name_en . ' - ' . $homeworks_order->course->ed_class->name_ar}}

                        <br>
                        @if ($homeworks_order->homework_services->count() == '0')
                            <span class="badge badge-info badge-lg">{{__('Normal Homework')}}</span>
                        @else
                            @foreach ($homeworks_order->homework_services as $homework_service)
                                <span class="badge badge-info badge-lg">{{app()->getLocale() == 'ar' ? $homework_service->name_ar : $homework_service->name_en}}</span>
                            @endforeach
                        @endif
                    </td>
                    <td  class="text-center">
                        {{ $homeworks_order->total_price . ' ' .  $homeworks_order->user->country->currency}}

                        @php
                        $rejected_count = 0 ;
                        $refund = 0 ;
                        $order_requests_count = 0 ;
                        $homework_services_price = 0 ;
                        @endphp

                        @foreach ($homeworks_order->home_works as $homework_request)




                        @if ($homework_request->status == 'rejected')

                        @php
                            $rejected_count = $rejected_count + 1 ;
                        @endphp

                        @endif

                        @endforeach

                        @php

                            foreach ($homeworks_order->homework_services as $homework_services) {

                                $homework_services_price += $homework_services->price;

                            }

                        $order_requests_count = $homeworks_order->quantity + $homeworks_order->home_works->count() - $rejected_count;
                        $refund = (($homeworks_order->quantity) * $homeworks_order->course->homework_price) +  (($homeworks_order->quantity) * $homework_services_price);

                        @endphp


                            @if ($homeworks_order->status == 'canceled')

                                <br>
                                {{__('Refund : ') . $refund}}

                            @endif


                    </td>
                    <td class="text-center">{{$homeworks_order->wallet_balance}} {{' ' . $homeworks_order->user->country->currency}}</td>
                    <td  class="text-center">
                        {{ $order_requests_count }}

                        @if ($homeworks_order->status == 'canceled')

                        <br>
                        {{__('Count Refunded : ') . $homeworks_order->quantity}}

                        @endif

                    </td>
                    <td class="project-state">
                        @switch($homeworks_order->status)
                        @case('waiting')
                        <span class="badge badge-danger badge-lg">{{__('Waiting for payment')}}</span>
                            @break
                        @case('done')
                        <span class="badge badge-success badge-lg">{{__('Payment Done')}}</span>
                            @break
                            @case('canceled')
                            <span class="badge badge-danger badge-lg">{{__('the request has been canceled')}}</span>
                            @break
                        @default
                        @endswitch






                    </td>
                    <td  class="text-center"><small>{{ $homeworks_order->created_at }}</small></td>

                </tr>
                      @endforeach


              </tbody>
          </table>

          <div class="row mt-3"> {{ $homeworks_orders->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">{{__('No homeworks orders To Show')}}</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->




  @endsection

