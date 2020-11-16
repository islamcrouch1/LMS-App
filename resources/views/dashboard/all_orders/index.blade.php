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
        <div class="col-md-6">
          <form action="">
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                <input type="text" name="search" autofocus placeholder="Search by user.." class="form-control" value="{{request()->search}}">
                </div>
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>Search by user</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-6">
          <form action="">
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                <input type="text" name="search_order" autofocus placeholder="Search by order.." class="form-control" value="{{request()->search_order}}">
                </div>
              </div>
              <div class="col-md-4">
              <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>Search by order</button>
              </div>
            </div>
          </form>
        </div>
      </div>


      <div class="row">

        <div class="col-md-8">

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

                           <th>
                            Total price
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
                            {{ $order->total_price }}
                        </small>
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
                                data-url="{{ route('all_orders.products',[app()->getLocale() , $order->id ] ) }}"
                                data-method="get"
                                >
                                    <i class="fa fa-list"></i>
                                    show products
                                </button>

                                @if (!$order->trashed())
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

            </div><!-- end of col -->
        </div>

      </div>



    </section>
    <!-- /.content -->


  @endsection
