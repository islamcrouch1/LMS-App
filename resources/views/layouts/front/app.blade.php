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

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
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




    <link rel="stylesheet" href="{{ asset('newasset/noty/noty.css') }}">
    <script src="{{ asset('newasset/noty/noty.min.js') }}"></script>


    <style>


        p , h1 , h2 , h3 , h4 , h5 , h6 , span , a {
            font-family: 'Cairo', sans-serif !important;

        }

        .mr-2{
            margin-right: 5px;
        }

        .loaderr {
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #367FA9;
            width: 60px;
            height: 60px;
            -webkit-animation: spin 1s linear infinite; /* Safari */
            animation: spin 1s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .modal .popover, .modal .tooltip {
            z-index:100000000;
        }
        .carousel{
            width : 100% !important;
        }

        .badge {
  padding-left: 9px;
  padding-right: 9px;
  -webkit-border-radius: 9px;
  -moz-border-radius: 9px;
  border-radius: 9px;
}

.label-warning[href],
.badge-warning[href] {
  background-color: #c67605;
}
#lblCartCount {
    font-size: 14px;
    background: #ff0000;
    color: #fff;
    padding: 0 5px;
    vertical-align: top;
    margin-left: -10px;
}


[dir=ltr] .fa, [dir=ltr] .far, [dir=ltr] .fas {
    font-family: Font Awesome\ 5 Free !important;
    font-size: 30px;
    color: hsla(0,0%,100%,.7);;
}

.social i {
    color: blue !important;
    font-size: 20px !important;
}
.modal-backdrop{
    display:none !important;
}
.navbar-expand .nav-link {
    height: 64px;
    color: #fff;
}

.navbar-expand .nav-link:hover {
    height: 64px;
    color: #fff;
}

    </style>





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






        </div>
        <!-- // END Header Layout -->


@include('layouts.front._aside')

@include('layouts.front._footer')


    </div>


        <!-- jQuery -->
        <script src="{{ asset('newasset/vendor/jquery.min.js') }}"></script>

        <script src="{{ asset('newasset/js/orderFront.js') }}"></script>
        <script src="{{ asset('newasset/js/cart.js') }}"></script>


        <script src="{{ asset('newasset/vendor/popper.min.js') }}"></script>

    <!-- Bootstrap -->
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



        $(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'focus'
                })
            })

    </script>



@stack('scripts-front')

</body>

</html>
