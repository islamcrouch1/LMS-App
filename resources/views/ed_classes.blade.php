@extends('layouts.front.app')



@section('content')

<div class="container page__container">


<div class="page-separator pt-5 pb-5">
    <div class="page-separator__text">{{ app()->getLocale() == 'ar' ? $ed_class->name_ar : $ed_class->name_en}}</div>
</div>



<div class="row card-group-row">
 @foreach ($ed_class->courses as $course)

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
                        <a style="width:100%;" href="{{route('course-order' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'course'=>$course->id , 'country'=>$scountry->id])}}" class="btn btn-primary">{{__('Buy Now')}}</a>
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

});


</script>

@endpush
