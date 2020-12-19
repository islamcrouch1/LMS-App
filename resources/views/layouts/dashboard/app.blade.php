<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{csrf_token()}}">

  <!-- Font Awesome -->


  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">


  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <link type="text/css" href="{{ asset('newasset/css/intlTelInput.css') }}" rel="stylesheet">







  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>


  <link rel="stylesheet" href="{{ asset('newasset/noty/noty.css') }}">
  <script src="{{ asset('newasset/noty/noty.min.js') }}"></script>


  <script>
          $(document).ready(function(){


                    $('.delete').on('click' , function(e){
                            e.preventDefault();
                            var that = $(this);
                            var n = new Noty({
                                type: 'alert alert-warning p-3',
                                layout: 'topRight',
                                theme: 'bootstrap-v4',
                                text : "Confirm Deleting Record",
                                killer : true,
                                buttons : [Noty.button('yes' , 'btn btn-success mr-3' , function(){
                                    that.closest('form').submit();
                                }), Noty.button('No' , 'btn btn-danger' , function(){
                                    n.close();
                                })]
                            });

                            n.show();
                        });

                        $(".img").change(function() {

                            if (this.files && this.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                            $('.img-prev').attr('src', e.target.result);
                            }

                            reader.readAsDataURL(this.files[0]); // convert to base64 string
                            }

                            });
         });


  </script>

  {{-- @if (app()->getLocale() == 'ar')

  <style>


  </style>

  @endif --}}

  <style>
    .mr-2{
        margin-right: 5px;
    }

    .loader {
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


    .iti__flag {background-image: url("/newasset/images/flags.png");}

@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
  .iti__flag {background-image: url("/newasset/images/flags@2x.png");}
}

.iti__selected-flag{
    direction: ltr;
}

.iti__country {
    padding: 5px 10px;
    outline: none;
    direction: ltr;
}


#phone{
    direction: ltr !important;
}

#parent_phone{
    direction: ltr !important;
}

.iti {
    position: relative;
    display: inline-block;
    width: 100%;
}

.btn{
    margin:2px;
}

</style>



   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


   @stack('style')


</head>
<body class="hold-transition login-page">


    <div class="wrapper" style="width:100%">

@include('layouts.dashboard._header')

          <!-- Main Sidebar Container -->



@include('layouts.dashboard._aside')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

@include('layouts.dashboard._flash')


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
        <strong>Copyright &copy; 2020 <a href="{{route('dashboard' , app()->getLocale())}}">AMLS Admin</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Version</b> 1
        </div>
      </footer>
    </div>
    <!-- ./wrapper -->





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

<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>


<!-- PAGE SCRIPTS -->
<script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script>


<script src="{{ asset('newasset/js/lesson.js') }}"></script>
<script src="{{ asset('newasset/js/order.js') }}"></script>
<script src="{{ asset('newasset/js/printThis.js') }}"></script>



<script src="{{ asset('newasset/js/playerjs.js') }}"></script>

<script src="{{ asset('newasset/js/intlTelInput.js') }}"></script>


<script src="{{ asset('newasset/js/select2.js') }}"></script>












<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>





<script>

                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });



            $('.select4').select2({
                 width: '100%'
             });

                var input = document.querySelector("#phone");
                window.intlTelInput(input, {
                    separateDialCode: true,
                    preferredCountries:["kw"],
                    utilsScript: "/newasset/js/utils.js?<%= time %>"
                });


                var input = document.querySelector("#parent_phone");
                window.intlTelInput(input, {
                    separateDialCode: true,
                    preferredCountries:["kw"],
                    utilsScript: "/newasset/js/utils.js?<%= time %>"

                });


    $(document).ready(function(){








        $(".img").change(function() {

            if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
            $('.img-prev').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]); // convert to base64 string
            }

            });



            $('.radio1').on('click' ,function(){

                $('.down_link').css('display' , 'block');

                });

                $('.radio2').on('click' ,function(){

                    $('.down_link').css('display' , 'none');

                    $('input[name=down_link]').val('#');

                    });

                    $('.type-select').on('change', function() {

                    if(this.value == "teacher" || this.value == "employee"){
                        $('.parent-phone-div').css('display', 'none');
                        $('#parent_phone').val("#");

                    }else{
                        $('.parent-phone-div').css('display', 'flex');
                        $('#parent_phone').val("");
                    }

                    });


                    $('.btn').on('click' , function(){

                    $("#phone").val($(".iti__selected-dial-code").html() + $("#phone").val());

                    $("#parent_phone").val($(".iti__selected-dial-code").html() + $("#parent_phone").val());

                    $(this).closest('form').submit();

                    $(".btn").attr("disabled", true);

                    });


      });



</script>

@stack('scripts')



</body>
</html>



