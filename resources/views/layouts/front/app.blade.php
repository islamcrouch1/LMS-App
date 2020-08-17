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

@include('layouts.front._header')

                
            <!-- Header Layout Content -->
            <div class="mdk-header-layout__content page-content ">
                    <main class="">
                        @yield('content')
                    </main>
            </div>
            <!-- // END Header Layout Content -->



@include('layouts.front._footer')


        </div>
        <!-- // END Header Layout -->


@include('layouts.front._aside')


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