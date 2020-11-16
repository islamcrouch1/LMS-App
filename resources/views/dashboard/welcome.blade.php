@extends('layouts.dashboard.app')

@section('adminContent')



      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Admin Panel</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href={{route('dashboard' , app()->getLocale())}}>Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <a  class="info-box-icon bg-success elevation-1" href="{{route('products.index' , app()->getLocale())}}"><span><i class="fas fa-shopping-cart"></i></span></a>

                <div class="info-box-content">
                  <span class="info-box-text">products</span>
                  <span class="info-box-number">{{$products_count}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <a  class="info-box-icon bg-warning elevation-1" href="{{url(app()->getLocale() . '/dashboard/users' )}}"><span><i class="fas fa-users"></i></span></a>

                <div class="info-box-content">
                  <span class="info-box-text">Users</span>
                  <span class="info-box-number">{{$users_count}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <a class="info-box-icon bg-danger elevation-1" href="{{route('all_orders.index' , app()->getLocale())}}"><span ><i class="fas fa-shopping-bag"></i></span></a>

                  <div class="info-box-content">
                    <span class="info-box-text">Orders</span>
                    <span class="info-box-number">{{$orders_count}}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <a class="info-box-icon bg-dark elevation-1" href="{{route('categories.index' , app()->getLocale())}}"><span><i class="fas fa-folder"></i></span></a>

                  <div class="info-box-content">
                    <span class="info-box-text">Libirary Categories</span>
                    <span class="info-box-number">{{$categories_count}}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!--/. container-fluid -->
      </section>
      <!-- /.content -->







@endsection
