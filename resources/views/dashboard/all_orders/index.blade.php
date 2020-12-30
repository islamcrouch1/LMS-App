@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>orders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">orders</li>
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
                <input type="text" name="search" autofocus placeholder="Search by Name .." class="form-control" value="{{request()->search}}">
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
                    <option value="recieved" {{request()->status == 'recieved' ? 'selected' : ''}}>{{__('Awaiting review from management')}}</option>
                    <option value="processing" {{request()->status == 'processing' ? 'selected' : ''}}>{{__('Your order is under review')}}</option>
                    <option value="shipped" {{request()->status == 'shipped' ? 'selected' : ''}}>{{__('Your order has been shipped')}}</option>
                    <option value="completed" {{request()->status == 'completed' ? 'selected' : ''}}>{{__('You have successfully received your request')}}</option>
                    <option value="canceled" {{request()->status == 'canceled' ? 'selected' : ''}}>{{__('The order has been canceled')}}</option>
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="payment_status" style="display:inline-block">
                  <option value="" selected>{{__('Payment Status')}}</option>
                    <option value="waiting" {{request()->payment_status == 'waiting' ? 'selected' : ''}}>{{__('Waiting for payment')}}</option>
                    <option value="done" {{request()->payment_status == 'done' ? 'selected' : ''}}>{{__('Payment Done')}}</option>
                </select>
              </div>
              <div class="col-md-2">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
              </div>
            </div>
          </form>
        </div>
      </div>


      <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">


                <h3 class="card-title">orders</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body p-0">
                  @if($orders->count() > 0)
                  <table class="table table-striped projects">
                      <thead>
                          <tr>
                              <th>
                                  #id
                              </th>
                              <th>
                                   Client Name
                              </th>

                              <th class="text-center">{{__('Paid Amount')}}</th>
                              <th class="text-center">{{__('Wallet Balance')}}</th>
                              <th>{{__('Shipping fee')}}</th>

                            <th>
                                Payment Status
                                </th>

                            <th>
                                Created At
                            </th>
                            <th>
                              Updated At
                          </th>
                          <?php if($orders !== Null){$order = $orders[0];} ?>
                          @if ($order->trashed())
                          <th>
                            Deleted At
                          </th>
                          @endif
                              <th style="" class="">
                                Actions
                              </th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>

                              @foreach ($orders as $order)
                            <td>
                                {{ $order->id }}
                            </td>

                            <td>
                                <small>
                                    {{ $order->user->name }}
                                </small>
                            </td>
                      <td>
                        <small>
                            {{ $order->total_price . ' ' . $order->user->country->currency }}
                        </small>
                    </td>
                    <td class="text-center">{{$order->wallet_balance}} {{' ' . $order->user->country->currency}}</td>
                    <td class="text-center">{{$order->shipping}} {{' ' . $order->user->country->currency}}</td>
                    <td class="project-state">


                        @switch($order->payment_status)
                        @case('waiting')
                        <span class="badge badge-danger badge-lg">{{__('Waiting for payment')}}</span>
                            @break
                        @case('done')
                        <span class="badge badge-success badge-lg">{{__('Payment Done')}}</span>
                            @break
                        @default
                        @endswitch

                        @switch($order->status)
                        @case('recieved')
                        <span class="badge badge-success badge-lg">{{__('Awaiting review from management')}}</span>
                            @break
                        @case("processing")
                        <span class="badge badge-warning badge-lg">{{__('Your order is under review')}}</span>
                        @break
                        @case("shipped")
                        <span class="badge badge-info badge-lg">{{__('Your order has been shipped')}}</span>
                        @break
                        @case("completed")
                        <span class="badge badge-primary badge-lg">{{__('You have successfully received your request')}}</span>
                        @break
                        @case("canceled")
                        <span class="badge badge-danger badge-lg">{{__('The order has been canceled')}}</span>
                        @break
                        @default
                        @endswitch

                    </td>

                        <td>
                                <small>
                                    {{ $order->created_at }}
                                </small>
                            </td>
                            <td>
                              <small>
                                  {{ $order->updated_at }}
                              </small>
                          </td>
                          @if ($order->trashed())
                          <td>
                            <small>
                                {{ $order->deleted_at }}
                            </small>
                        </td>
                          @endif
                            <td class="project-actions">

                                <button class="btn btn-primary btn-sm order-products"
                                data-url="{{ route('all_orders.products',['lang'=> app()->getLocale() , 'order'=> $order->id , 'user'=> $order->user->id ] ) }}"
                                data-method="get"
                                >
                                    <i class="fa fa-list"></i>
                                    show products
                                </button>

                                @if ($order->status != 'canceled')

                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-primary-{{$order->id}}">
                                    {{__('Change Request Status')}}
                                </button>

                                @endif



                                @if (!$order->trashed())

                                @if ($order->status != 'canceled')

                                    @if (auth()->user()->hasPermission('all_orders-update'))
                                        <a class="btn btn-info btn-sm" href="{{route('orders.edit' , ['lang'=>app()->getLocale() , 'order'=>$order->id , 'user'=>$order->user->id])}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                    @else
                                        <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                        </a>
                                    @endif

                                @endif

                                @else
                                @if (auth()->user()->hasPermission('all_orders-restore'))

                                <a class="btn btn-info btn-sm" href="{{route('all_orders.restore' , ['lang'=>app()->getLocale() , 'all_order'=>$order->id])}}">
                                  <i class="fas fa-pencil-alt">
                                  </i>
                                  Restore
                              </a>
                              @else
                              <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Restore
                            </a>
                            @endif
                                        @endif

                                        @if ((auth()->user()->hasPermission('all_orders-delete'))| (auth()->user()->hasPermission('all_orders-trash')))

                                            <form method="POST" action="{{route('all_orders.destroy' , ['lang'=>app()->getLocale() , 'all_order'=>$order->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm delete">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                            @if ($order->trashed())
                                                            {{ __('Delete') }}
                                                            @else
                                                            {{ __('Trash') }}
                                                            @endif
                                                        </button>
                                            </form>
                                            @else
                                            <button  class="btn btn-danger btn-sm">
                                              <i class="fas fa-trash">
                                              </i>
                                              @if ($order->trashed())
                                              {{ __('Delete') }}
                                              @else
                                              {{ __('Trash') }}
                                              @endif
                                          </button>
                                          @endif


                            </td>
                        </tr>
                              @endforeach


                      </tbody>
                  </table>

                  <div class="row mt-3"> {{ $orders->appends(request()->query())->links() }}</div>

                  @else <h3 class="pl-2">No orders To Show</h3>
                  @endif
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->



        </div>

{{--
            <div class="col-md-4">

                <div class="card">

                    <div class="card-header">


                    <h3 class="card-title">Show Products</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                    </div>
                    </div>

                    <div class="card-body p-0">


                    <div class="box-body">

                        <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                            <div class="loader"></div>
                            <p style="margin-top: 10px">Loading ....</p>
                        </div>

                        <div id="order-product-list">





                        </div><!-- end of order product list -->


                    </div><!-- end of box body -->

                </div><!-- end of box -->

            </div><!-- end of col --> --}}
        </div>

      </div>



    </section>
    <!-- /.content -->

    @foreach ($orders->reverse() as $order)





    <div class="modal fade" id="modal-primary-{{$order->id}}">
        <div class="modal-dialog">
          <div class="modal-content bg-primary">
            <div class="modal-header">
              <h4 style="direction: rtl;" class="modal-title">{{__('Change Request Status for - ') . $order->user->name}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="{{route('orders.update.order', ['lang'=> app()->getLocale() , 'order'=>$order->id ])}}" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label">{{ __('Select Status') }}</label>
                        <div class="col-md-8">

                            @php
                            $order_status = ['recieved' , 'processing' , 'shipped' , 'completed' , 'canceled']
                            @endphp

                            <select style="height: 50px;" class=" form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required autocomplete="status">
                                @foreach ($order_status as $order_status)

                                @switch($order_status)
                                    @case('recieved')
                                    <option value="{{$order_status}}" {{ ($order_status == $order->status) ? 'selected' : '' }}>{{__('Awaiting review from management')}}</option>
                                        @break
                                    @case("processing")
                                    <option value="{{$order_status}}" {{ ($order_status == $order->status) ? 'selected' : '' }}>{{__('Your order is under review')}}</option>
                                    @break
                                    @case("shipped")
                                    <option value="{{$order_status}}" {{ ($order_status == $order->status) ? 'selected' : '' }}>{{__('Your order has been shipped')}}</option>
                                    @break
                                    @case("completed")
                                    <option value="{{$order_status}}" {{ ($order_status == $order->status) ? 'selected' : '' }}>{{__('You have successfully received your request')}}</option>
                                    @break
                                    @case("canceled")
                                    <option value="{{$order_status}}" {{ ($order_status == $order->status) ? 'selected' : '' }}>{{__('The order has been canceled')}}</option>
                                    @break
                                    @default
                                @endswitch

                                @endforeach
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-outline-light">{{__('Save changes')}}</button>
                </div>

            </form>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

      @endforeach



      <div class="modal fade" id="modal-order">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 style="direction: rtl;" class="modal-title">{{__('Show Details for order')}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">


                <div class="box-body">

                    <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                        <div class="loader"></div>
                        <p style="margin-top: 10px">Loading ....</p>
                    </div>

                    <div id="order-product-list">





                    </div><!-- end of order product list -->


                </div><!-- end of box body -->



            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{__('Close')}}</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


  @endsection
