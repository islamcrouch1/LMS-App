@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Courses Orders')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('Courses Orders')}}</li>
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
                <input type="text" name="search" autofocus placeholder="{{__('Search By Student Name ..')}}" class="form-control" value="{{request()->search}}">
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
                </select>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
                {{-- @if (auth()->courses_order()->hasPermission('courses_orders-create'))
                <a href="{{route('courses_orders.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">{{__('Create courses_order')}}</button></a>
                @else
                <a href="#" disabled> <button type="button" class="btn btn-primary">{{__('Create courses_order')}}</button></a>
                @endif --}}
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">{{__('Courses Orders')}}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($courses_orders->count() > 0)
          <table class="table table-striped projects">
              <thead>

                  <tr>

                    <th class="text-center">#id</th>
                    <th class="text-center">{{__('Profile')}}</th>
                    <th class="text-center">{{__('Student Name')}}</th>
                    <th class="text-center">{{__('Total Price')}}</th>
                    <th class="text-center">{{__('Status')}}</th>
                    <th class="text-center">{{__('Order Date')}}</th>

                  </tr>

              </thead>

              <tbody>

                  <tr>

                    @foreach ($courses_orders->reverse() as $courses_order)
                    <td  class="text-center">{{ $courses_order->id }}</td>
                    <td  class="text-center"><img alt="Avatar" class="table-avatar" src="{{ asset('storage/images/users/' . $courses_order->user->profile) }}"></td>
                    <td  class="text-center"><small><a href="{{route('users.show' , [app()->getLocale() , $courses_order->user->id])}}">
                        {{ $courses_order->user->name }}
                    </a></small></td>
                    <td  class="text-center">{{ $courses_order->total_price . ' ' .  $courses_order->user->country->currency}}</td>
                    <td class="project-state">
                        @switch($courses_order->status)
                        @case('waiting')
                        <span class="badge badge-danger badge-lg">{{__('Waiting for payment')}}</span>
                            @break
                        @case('done')
                        <span class="badge badge-success badge-lg">{{__('Payment Done')}}</span>
                            @break
                        @default
                        @endswitch
                    </td>
                    <td  class="text-center"><small>{{ $courses_order->created_at }}</small></td>

                </tr>
                      @endforeach


              </tbody>
          </table>

          <div class="row mt-3"> {{ $courses_orders->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">{{__('No courses orders To Show')}}</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->




  @endsection

