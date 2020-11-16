<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- Styles -->


    <?php $locale = App::getLocale(); ?>

    <?php if (App::isLocale('en')) {  ?>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <?php  }else{ ?>
        <link href="{{ asset('css/apprtl.css') }}" rel="stylesheet">
    <?php  } ?>



    <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&display=swap" rel="stylesheet">

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="{{ asset('newasset/vendor/perfect-scrollbar.css') }}" rel="stylesheet">

    <!-- Fix Footer CSS -->
    <link type="text/css" href="{{ asset('newasset/vendor/fix-footer.css') }}" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="{{ asset('newasset/css/material-icons.css') }}" rel="stylesheet">


    <!-- Font Awesome Icons -->
    <link type="text/css" href="{{ asset('newasset/css/fontawesome.css') }}" rel="stylesheet">


    <!-- Preloader -->
    <link type="text/css" href="{{ asset('newasset/css/preloader.css') }}" rel="stylesheet">


    <!-- App CSS -->
    <link type="text/css" href="{{ asset('newasset/css/app.css') }}" rel="stylesheet">






</head>





























<body class="layout-sticky-subnav layout-default ">

    <div class="preloader">
        <div class="sk-double-bounce">
            <div class="sk-child sk-double-bounce1"></div>
            <div class="sk-child sk-double-bounce2"></div>
        </div>
    </div>


    <div id="app">







        <!-- Header Layout -->
        <div class="mdk-header-layout js-mdk-header-layout">

                <!-- Header -->

                <div id="header" class="mdk-header mdk-header--bg-dark bg-dark js-mdk-header mb-0" data-effects="parallax-background waterfall" data-fixed data-condenses>
                    <div class="mdk-header__bg">
                        <div class="mdk-header__bg-front" style="background-image: url({{ asset('newasset/images/photodune-4161018-group-of-students-m.jpg') }});"></div>
                    </div>
                    <div class="mdk-header__content justify-content-center">



                        <div class="navbar navbar-expand navbar-dark-dodger-blue bg-transparent will-fade-background" id="default-navbar" data-primary>

                            <!-- Navbar toggler -->
                            <button class="navbar-toggler w-auto mr-16pt d-block rounded-0" type="button" data-toggle="sidebar">
                                <span class="material-icons">short_text</span>
                            </button>
                            <a href="{{ route('home' , ['lang'=> app()->getLocale() , 'country'=> '1']) }}" class="navbar-brand mr-16pt">
                                <!-- <img class="navbar-brand-icon" src="assets/images/logo/white-100@2x.png" width="30" alt="Luma"> -->

                                <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                                    <span class="avatar-title rounded bg-primary"><img src="{{ asset('newasset/images/illustration/student/128/white.svg') }}" alt="logo" class="img-fluid" /></span>

                                </span>

                                <span class="d-none d-lg-block">ALMS</span>
                            </a>

                        @guest

                            <ul class="nav navbar-nav ml-auto mr-0">
                                <li class="nav-item">
                                    <a href="{{ route('login' , app()->getLocale()) }}" class="nav-link" data-toggle="tooltip" data-title="{{ __('Login') }}" data-placement="bottom" data-boundary="window"><i class="material-icons">lock_open</i></a>
                                </li>
                                @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register' , app()->getLocale()) }}" class="btn btn-outline-white">{{ __('Register Now') }}</a>
                                </li>
                                @endif
                                @else
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
                        @endguest
                        </div>
                    </div>
                </div>

                <!-- // END Header -->


            <!-- Header Layout Content -->
            <div class="mdk-header-layout__content page-content ">
                    <main class="">
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login' , app()->getLocale()) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request'  , app()->getLocale()) }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
</div>
<!-- // END Header Layout Content -->



<div class="js-fix-footer2 bg-white border-top-2">
    <div class="container page__container page-section d-flex flex-column">
        <p class="text-70 brand mb-24pt">
            <img class="brand-icon" src="{{ asset('newasset/images/logo/black-70@2x.png') }}" width="30" alt="Luma"> ALMS
        </p>
        <p class="measure-lead-max text-50 small mr-8pt">{{__('ALMS is a beautifully crafted user interface for modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher Dashboard, Curriculum Management, Earnings and Reporting, ERP, HR, CMS, Tasks, Projects, eCommerce and more.')}}</p>
        {{-- <p class="mb-8pt d-flex">
            <a href="" class="text-70 text-underline mr-8pt small">Terms</a>
            <a href="" class="text-70 text-underline small">Privacy policy</a>
        </p> --}}
        <p class="text-50 small mt-n1 mb-0">{{__('Copyright 2020')}} &copy; {{__('All rights reserved.')}}</p>
    </div>
</div>

</div>
<!-- // END Header Layout -->


        <!-- drawer -->
        <div class="mdk-drawer js-mdk-drawer" id="default-drawer">
            <div class="mdk-drawer__content">
                <div class="sidebar sidebar-dark-dodger-blue sidebar-left" data-perfect-scrollbar>


                    <div class="d-flex align-items-center navbar-height">
                        <form action="fixed-index.html" class="search-form search-form--black mx-16pt pr-0 pl-16pt">
                            <input type="text" class="form-control pl-0" placeholder="{{__('search')}}">
                            <button class="btn" type="submit"><i class="material-icons">search</i></button>
                        </form>
                    </div>


                </div>
            </div>
        </div>
        <!-- // END drawer -->

</div>
<!-- jQuery -->
<script src="{{ asset('newasset/vendor/jquery.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('newasset/vendor/popper.min.js') }}"></script>
<script src="{{ asset('newasset/vendor/bootstrap.min.js') }}"></script>

<!-- Perfect Scrollbar -->
<script src="{{ asset('newasset/vendor/perfect-scrollbar.min.js') }}"></script>

<!-- DOM Factory -->
<script src="{{ asset('newasset/vendor/dom-factory.js') }}"></script>

<!-- MDK -->
<script src="{{ asset('newasset/vendor/material-design-kit.js') }}"></script>

<!-- Fix Footer -->
<script src="{{ asset('newasset/vendor/fix-footer.js') }}"></script>

<!-- App JS -->
<script src="{{ asset('newasset/js/app.js') }}"></script>

<script src="{{ asset('newasset/js/playerjs.js') }}"></script>


{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

<script>
(function() {
'use strict';
var headerNode = document.querySelector('.mdk-header')
var layoutNode = document.querySelector('.mdk-header-layout')
var componentNode = layoutNode ? layoutNode : headerNode

componentNode.addEventListener('domfactory-component-upgraded', function() {
    headerNode.mdkHeader.eventTarget.addEventListener('scroll', function() {
        var progress = headerNode.mdkHeader.getScrollState().progress
        var navbarNode = headerNode.querySelector('#default-navbar')
        navbarNode.classList.toggle('bg-transparent', progress <= 0.2)
    })
})
})()
</script>

@stack('scripts-front')

</body>

</html>
