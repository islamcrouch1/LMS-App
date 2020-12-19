@extends('layouts.front.app')



@section('content')

<div class="container page__container">


    <div class="page-separator pt-5 pb-5">
        <div class="page-separator__text">{{ app()->getLocale() == 'ar' ? $course->name_ar : $course->name_en}}</div>
    </div>



<div class="row mb-0">
    <div class="col-lg-7">


        <div class="accordion js-accordion accordion--boxed list-group-flush" id="parent">


            @auth


            @if (Auth::user()->course_orders->where('course_id' , $course->id)->where('status' , 'done')->count() > 0)

            @php

            $average = 0 ;
            $watched_count = 0 ;
            $sum = 0 ;

            foreach (Auth::user()->user_lessons->where('course_id' , $course->id) as $user_lesson) {
                $sum = $sum + 1 ;
                if($user_lesson->watched == 1){
                    $watched_count = $watched_count + 1 ;
                }
            }

            if($watched_count == 0){
                $average = 0 ;
            }else{

                $average = ($watched_count/$sum) * 100 ;
                $average = round($average);

            }
            @endphp

            <div class="col-lg-12 d-flex align-items-center">
                <div class="flex"
                    style="max-width: 100%">
                    <h6>{{__('Course Progress')}}</h6>
                </div>
            </div>
            <div class="col-lg-12 d-flex align-items-center pb-3">
                <div class="flex"
                    style="max-width: 100%">

                    <div class="progress"
                        style="height: 20px;">
                        <div class="progress-bar"
                            role="progressbar"
                            style="width: {{$average}}%;"
                            aria-valuenow="25"
                            aria-valuemin="0"
                            aria-valuemax="100">{{$average}}%</div>
                    </div>

                </div>
            </div>

            @endif

            @endauth


            <div class="accordion__item">
                <a href="#" class="accordion__toggle collapsed" data-toggle="collapse" data-target="#course-toc-1" data-parent="#parent">
                    <span class="flex">{{ app()->getLocale() == 'ar' ? $course->name_ar : $course->name_en}} - ({{__('Course Description')}})</span>
                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                </a>
                <div class="accordion__menu collapse" id="course-toc-1">
                    <div class="accordion__menu-link">
                        <p>@if  (app()->getLocale() == 'ar')  {!!$course->description_ar!!}  @else  {!!$course->description_en!!} @endif</p>
                    </div>
                </div>
            </div>

            @foreach ($course->chapters as $chapter)
            <div class="accordion__item mb-3">
            <a href="#" class="accordion__toggle" data-toggle="collapse" data-target="#course-chapter-{{$chapter->id}}" data-parent="#parent">
                    <span class="flex">{{ app()->getLocale() == 'ar' ? $chapter->name_ar : $chapter->name_en}}</span>
                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                </a>
                <div class="accordion__menu collapse show" id="course-chapter-{{$chapter->id}}">
                    @foreach ($chapter->lessons as $lesson)
                    <div class="accordion__menu-link active">
                        <!-- <span class="material-icons icon-16pt icon--left text-muted">lock</span> -->
                        <span class="icon-holder icon-holder--small icon-holder--primary rounded-circle d-inline-flex icon--left">
                            <i class="material-icons icon-16pt">play_circle_outline</i>
                        </span>


                        @auth


                        @if (Auth::user()->course_orders->where('course_id' , $course->id)->where('status' , 'done')->count() == 0)
                        <a class="flex {{$lesson->type == 0 ? '' : 'lesson_show'}}" href="{{$lesson->type == 0 ? route('lessons' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id  , 'country'=>$scountry->id , 'course'=>$course->id]) : '#'}}">{{ app()->getLocale() == 'ar' ? $lesson->name_ar : $lesson->name_en}}</a>

                            @if ($lesson->type == 1)
                            <i style="color:#000" class="fas fa-lock"></i>
                            @endif

                        @else
                        <a class="flex" href="{{route('lessons' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id , 'country'=>$scountry->id , 'course'=>$course->id])}}">{{ app()->getLocale() == 'ar' ? $lesson->name_ar : $lesson->name_en}}</a>
                            @if (Auth::user()->user_lessons->where('lesson_id' , $lesson->id)->first()->watched == 1)
                            <div class="row mr-1 ml-1">
                                <div class="col-md-12">
                                    <a href="{{ route('exam.questions' , ['lang'=>app()->getLocale() ,'lesson'=>$lesson->id , 'exam'=>$lesson->exam->id , 'user'=>Auth::id() , 'country'=>$scountry->id , 'course'=>$course->id])}}" class="btn btn-sm btn-success">{{__('Test your self')}}</a>
                                </div>
                            </div>
                            <i style="color:#5edb15" class="fas fa-check"></i>
                            @endif
                        @endif


                        @else

                        <a class="flex {{$lesson->type == 0 ? '' : 'lesson_show'}}" href="{{$lesson->type == 0 ? route('lessons' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id , 'country'=>$scountry->id , 'course'=>$course->id]) : '#'}}">{{ app()->getLocale() == 'ar' ? $lesson->name_ar : $lesson->name_en}}</a>

                            @if ($lesson->type == 1)
                            <i style="color:#000" class="fas fa-lock"></i>
                            @endif

                        @endauth

                        {{-- <span class="text-muted">50m 13s</span> --}}
                    </div>
                    @endforeach


                </div>
            </div>
            @endforeach


            <div class="col-md-6 text-right mb-3">
                @auth
                @if (Auth::user()->course_orders->where('course_id' , $course->id)->where('status' , 'done')->count() == 0)
                <a style="width:100%;" href="{{route('course-order' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'course'=>$course->id , 'country'=>$scountry->id])}}" class="btn btn-primary">{{__('Buy Now')}}</a>
                @else
                <div style="display:none" class="row course-exam">
                    <div class="col-md-12">
                        <a style="width:100%" href="{{ route('exam.questions' , ['lang'=>app()->getLocale() ,'lesson'=>'#' , 'exam'=>$course->exam->id , 'user'=>Auth::id() , 'country'=>$scountry->id , 'course'=>$course->id])}}" class="btn btn-primary">{{__('Full course exam')}}</a>
                    </div>
                </div>
                @endif
                @else
                <a style="width:100%;"  href="#" class="btn btn-primary course_order">{{__('Buy Now')}}</a>
                @endauth
            </div>

        </div>

    </div>

</div>
</div>
</div>

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

<div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{__("Dear student, you cannot view this lesson, you can purchase the course to be able to view all closed lessons")}}
        </div>
        <div class="modal-footer">
            @auth
            <a href="{{route('course-order' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'course'=>$course->id , 'country'=>$scountry->id])}}" class="btn btn-primary">{{__("Buy Now")}}</a>
            @endauth
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



    var progress = $('.progress-bar').html();

    console.log(progress);

    if(progress == '100%'){
        $('.course-exam').css('display' , 'block');
    }


    $('.course_order').on('click' , function(e){


        e.preventDefault();


        $('#exampleModalCenter').modal({
            keyboard: false
        });


    });


    $('.lesson_show').on('click' , function(e){


    e.preventDefault();


    $('#exampleModalCenter1').modal({
        keyboard: false
    });


    });

});


</script>

@endpush
