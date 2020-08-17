<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


  {{-- <?php $locale = App::getLocale(); ?>

  <?php if (App::isLocale('en')) {  ?> 
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <?php  }else{ ?>
      <link href="{{ asset('css/apprtl.css') }}" rel="stylesheet">
  <?php  } ?> 

   --}}


</head>
<body class="hold-transition login-page">

    <div class="wrapper" style="width:100%">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
              </li>
              @if (isset($user))
              <li class="nav-item">
                <a class="nav-link" href="{{route(Route::currentRouteName() , ['en' , $user->id]) }}">{{ __('English') }}</a>
              </li>
              <li class="nav-item">
                    <a class="nav-link" href="{{route(Route::currentRouteName() , ['ar' , $user->id])}}">{{ __('Arabic') }}</a>
              </li>
              @else
              <li class="nav-item">
                <a class="nav-link" href="{{route(Route::currentRouteName() , 'en') }}">{{ __('English') }}</a>
              </li>
              <li class="nav-item">
                    <a class="nav-link" href="{{route(Route::currentRouteName() , 'ar')}}">{{ __('Arabic') }}</a>
              </li>
              @endif
              
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout'  , app()->getLocale()) }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout' , app()->getLocale()) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            </ul>
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                    class="fas fa-th-large"></i></a>
              </li>
            </ul>
          </nav>
          <!-- /.navbar -->
        
          <!-- Main Sidebar Container -->
          <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
              <img src="{{ asset('newasset/images/illustration/student/128/white.svg') }}" class="brand-image img-circle elevation-3"
                   style="opacity: .8">
              <span class="brand-text font-weight-light">ALMS Admin</span>
            </a>
        
            <!-- Sidebar -->
            <div class="sidebar">
              <!-- Sidebar user panel (optional) -->
              <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                  <img src="{{ asset('storage/' . Auth::user()->profile) }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                  <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
              </div>
        
              <!-- Sidebar Menu -->
              <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
                       with font-awesome or any other icon font library -->
                  <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>
                        Dashboard
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Dashboard</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-copy"></i>
                      <p>
                        All Users
                        <i class="fas fa-angle-left right"></i>
                        <span class="badge badge-info right">0</span>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                     <li class="nav-item">
                            <a href="{{url(app()->getLocale() . '/admin/users' )}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                              </a>
                            </li>
                      <li class="nav-item">
                        <a href="{{route('users.trashed' , app()->getLocale())}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Trashed Users</p>
                        </a>
                      </li>

                    </ul>
                  </li>
      
      
                </ul>
              </nav>
              <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
          </aside>
              <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
        
          @if (session()->has('success'))
            <div class="col-md-3">
                <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Success</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                    </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{session()->get('success')}}
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>  
          @endif


@yield('adminContent')


    </div>
    <!-- /.content-wrapper -->
    <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    
      <!-- Main Footer -->
      <footer class="main-footer">
        <strong>Copyright &copy; 2020 <a href="#">AMLS Admin</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Version</b> 1
        </div>
      </footer>
    </div>
    <!-- ./wrapper -->




<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('dist/js/demo.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<!-- PAGE SCRIPTS -->
<script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script>

</body>
</html>



