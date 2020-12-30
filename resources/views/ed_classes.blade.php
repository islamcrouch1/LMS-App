@extends('layouts.front.app')



@section('content')

<div class="container page__container">


<div class="page-separator pt-5 pb-5">
    <div class="page-separator__text">{{ app()->getLocale() == 'ar' ? $ed_class->name_ar : $ed_class->name_en}}</div>
</div>



<div class="row card-group-row">
 @foreach ($ed_class->courses->reverse() as $course)

 @if ($course->status == 1)
 <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

    <div class="card card-sm card--elevated p-relative o-hidden overlay js-overlay mdk-reveal js-mdk-reveal card-group-row__card" >


        <a href="fixed-student-course.html" class="js-image" data-position="">
            <img style="width:100%" src="{{ asset('storage/' . $course->image) }}" alt="course-image">
            <span class="overlay__content align-items-start justify-content-start">
                <span class="overlay__action card-body d-flex align-items-center">
                    <i class="material-icons mr-4pt">play_circle_outline</i>
                    <span class="card-title text-white">Preview</span>
                </span>
            </span>
        </a>

            <div style="background: #fff; z-index: 1000000; class="card-body">
                <div class="d-flex">
                    <div class="flex p-2">
                        <a class="card-title" href="fixed-student-course.html">{{ app()->getLocale() == 'ar' ? $course->name_ar : $course->name_en}} {{' - ' . $course->course_price . ' ' . $course->country->currency}}</a>
                        <small class="text-50 font-weight-bold mb-4pt"></small>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        @auth
                        <a style="width:100%;" id="" href="#course_order_buy{{$course->course_price}}" class="btn btn-primary course_order_buy" data-price="{{$course->course_price}}" data-course_id="{{$course->id}}">{{__('Buy Now')}}</a>
                        @else
                        <a style="width:100%;"  href="#" class="btn btn-primary course_order">{{__('Buy Now')}}</a>
                        @endauth
                    </div>
                    <div class="col-md-6">
                        <a style="width:100%;" href="{{route('courses' , ['lang'=>app()->getLocale() , 'course'=>$course->id , 'country'=>$scountry->id])}}" class="btn btn-primary">{{__('Details')}}</a>
                    </div>


                </div>

            </div>
    </div>


</div>
 @endif
 @endforeach


 <div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{__("Please login to make this request, if you don't have account please register one now ....")}}
        </div>
        <div class="modal-footer">
        <a href="{{ route('login' , ['lang'=> app()->getLocale() , 'country'=> $scountry->id]) }}" class="btn btn-primary">{{__("Login")}}</a>
          <a href="{{ route('register', ['lang'=> app()->getLocale() , 'country'=> $scountry->id]) }}" class="btn btn-success">{{__("Register")}}</a>
        </div>
      </div>
    </div>
  </div>


</div>

</div>

@auth
@foreach ($ed_class->courses->reverse() as $course)

<div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter2{{$course->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <form method="POST" action="{{route('course-order' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'course'=>$course->id , 'country'=>$scountry->id])}}" enctype="multipart/form-data">
            @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Specify the order details')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body"  style="text-align:{{app()->getLocale() == 'ar' ? 'right' : 'left' }}">

            <h4>{{ app()->getLocale() == 'ar' ? $course->name_ar . ' - ' . $course->ed_class->name_ar : $course->name_en . ' - ' . $course->ed_class->name_en }}</h4>


            <div class="form-group row">
                <label for="course" class="col-md-6 col-form-label">{{ __('Use from your wallet balance') }}</label>
                @if (Auth::check())
                    @php
                       $student = App\User::find(Auth::id());
                    @endphp
                @endif
                <div class="col-md-4">
                    <input id="used_balance{{$course->id}}" type="number" name="used_balance" class="form-control input-sm used_balance3" min="0" value="0" data-wallet_balance="{{$student->wallet->balance}}" data-course_id="{{$course->id}}"  data-price="{{$course->course_price}}">
                </div>
            </div>

        </div>
        <div class="modal-footer">

            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h4>{{__('Total : ')}}<span id="total-price{{$course->id}}" class="">0</span><span>{{' ' . $course->country->currency}}</span></h4>
                    </div>
                    <div class="col-md-4">
                        <a style="color:#fff" type="submit" class="btn btn-primary orderbtn">
                          {{__("Buy Now")}}
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
      </div>
    </div>
</div>

@endforeach
@endauth


<div style="z-index: 10000000000000000 !important" class="modal fade" id="balance_alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{__("You have exceeded the maximum balance in your wallet, the available balance is now in the wallet: ")}} <span class="available-quantity"></span> {{$scountry->currency}}
        </div>
      </div>
    </div>
  </div>


@endsection


@push('scripts-front')

<script>
$(document).ready(function(){



    $('.course_order').on('click' , function(e){


        e.preventDefault();


        $('#exampleModalCenter').modal({
            keyboard: false
        });


    });



    $('.course_order_buy').on('click' , function(e){

        var price = $(this).data('price');
        var course_id = $(this).data('course_id');
        var totalprice = '#total-price' + course_id ;
        var used_balance = '#used_balance' + course_id ;
        var modal = '#exampleModalCenter2' + course_id ;

        $(used_balance).val(0);
        $(totalprice).html(price);

        $(modal).modal({
            keyboard: false
        })


        $('body').on('keyup change', '.used_balance3', function() {


            var used_balance = Number($(this).val());

            var wallet_balance = $(this).data('wallet_balance');

            if(used_balance > wallet_balance){

                $('#balance_alert').modal({
                    keyboard: false
                });

                $('.available-quantity').empty();
                $('.available-quantity').html(wallet_balance);

                $(this).val(wallet_balance);

                used_balance = wallet_balance ;

            }

            if(used_balance < 0 ){

                $(this).val(0);
            }

            var price = $(this).data('price');
            var price1 = $(this).data('price');
            var course_id = $(this).data('course_id');

            var totalprice = '#total-price' + course_id ;

            var price = price - used_balance ;

            if(price < 0){

                $(this).val(price1);

                price = 0 ;

            }


            $(totalprice).html(price);


            console.log(used_balance);
            console.log(wallet_balance);
            console.log(course_id);
            console.log(price);




            });//end of product quantity change


    });

});


</script>

@endpush
