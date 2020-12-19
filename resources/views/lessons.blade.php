@extends('layouts.front.app')



@section('content')



{{-- <div class="page-separator pt-5 pb-5">
    <div class="page-separator__text">{{ app()->getLocale() == 'ar' ? $lesson->name_ar : $lesson->name_en}}</div>
</div> --}}

@if (Auth::user()->course_orders->where('course_id' , $course->id)->where('status' , 'done')->count() > 0 || $slesson->type == 0)


<div class="pb-lg-64pt py-32pt">
    <div class="container page__container">

        <div class="row">
            <div class="col-md-8">

                <div class="container page__container">

                    <div id="player"></div>



                </div>

            </div>

            <div class="col-md-4">

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

                    <div class="col-lg-12 d-flex align-items-center pt-2 pr-1">
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
                                    aria-valuenow="{{$average}}"
                                    aria-valuemin="0"
                                    aria-valuemax="100">{{$average}}%</div>
                            </div>

                        </div>
                    </div>

                    @endif

                    @endauth


                    <div class="accordion__item">
                        <a href="#" class="accordion__toggle collapsed" data-toggle="collapse" data-target="#lesson-toc-1" data-parent="#parent">
                            <span class="flex">{{ app()->getLocale() == 'ar' ? $slesson->name_ar : $slesson->name_en}} - ({{__('Lesson Description')}})</span>
                            <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                        </a>
                        <div class="accordion__menu collapse" id="lesson-toc-1">
                            <div class="accordion__menu-link">
                                <p>@if  (app()->getLocale() == 'ar')  {!!$slesson->description_ar!!}  @else  {!!$slesson->description_en!!} @endif</p>
                            </div>

                            @if($slesson->lesson_file != '#' )


                            <div class="form-group row down_link p-3">
                                <div class="col-md-10">
                                    <a class="btn-info" style="padding: 10px; border-radius: 5px;" href="{{ asset('storage/lessons/files/' . $slesson->lesson_file) }}">{{__('Download Lesson File')}}</a>
                                </div>
                            </div>

                            @endif
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
                            <div class="accordion__menu-link active {{ $lesson->id == $slesson->id ? 'lesson_selected' : ''}}">
                                <!-- <span class="material-icons icon-16pt icon--left text-muted">lock</span> -->



                                @auth



                                @if (Auth::user()->course_orders->where('course_id' , $course->id)->where('status' , 'done')->count() == 0)
                                <input class="lesson_watched" type="hidden"
                                data-watched="0"

                                >
                                <a class="flex {{$lesson->type == 0 ? '' : 'lesson_show'}}" href="{{$lesson->type == 0 ? route('lessons' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id , 'country'=>$scountry->id , 'course'=>$course->id]) : '#'}}">
                                    <span class="icon-holder icon-holder--small icon-holder--primary rounded-circle d-inline-flex icon--left">
                                        <i class="material-icons icon-16pt">{{$lesson->id == $slesson->id ? 'play_circle_filled' : 'play_circle_outline'}}</i>
                                    </span>
                                    {{ app()->getLocale() == 'ar' ? $lesson->name_ar : $lesson->name_en}}
                                </a>

                                    @if ($lesson->type == 1)
                                    <i style="color:#000" class="fas fa-lock"></i>
                                    @endif

                                @else
                                    @if ($lesson->id == $slesson->id)
                                    <input class="lesson_watched" type="hidden"
                                    data-watched="{{Auth::user()->user_lessons->where('lesson_id' , $slesson->id)->first()->watched}}"
                                    data-id="{{$slesson->id}}"
                                    >
                                    @endif
                                <a class="flex" href="{{route('lessons' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id , 'country'=>$scountry->id , 'course'=>$course->id])}}">
                                    <span class="icon-holder icon-holder--small icon-holder--primary rounded-circle d-inline-flex icon--left">
                                        <i class="material-icons icon-16pt">{{$lesson->id == $slesson->id ? 'play_circle_filled' : 'play_circle_outline'}}</i>
                                    </span>
                                    {{ app()->getLocale() == 'ar' ? $lesson->name_ar : $lesson->name_en}}
                                </a>
                                    @if (Auth::user()->user_lessons->where('lesson_id' , $lesson->id)->first()->watched == 1)
                                    <div class="row mr-1 ml-1">
                                        <div class="col-md-12">
                                            <a href="{{ route('exam.questions' , ['lang'=>app()->getLocale() ,'lesson'=>$lesson->id , 'exam'=>$lesson->exam->id , 'user'=>Auth::id() , 'country'=>$scountry->id , 'course'=>$course->id])}}" class="btn btn-sm btn-success">{{__('Test your self')}}</a>
                                        </div>
                                    </div>
                                    <i style="color:#5edb15" class="fas fa-check"></i>

                                    @else

                                    @if ($lesson->id == $slesson->id)

                                    <div style="display:none" class="row mr-1 ml-1 test-div">
                                        <div class="col-md-12">
                                            <a href="{{ route('exam.questions' , ['lang'=>app()->getLocale() ,'lesson'=>$lesson->id , 'exam'=>$lesson->exam->id , 'user'=>Auth::id() , 'country'=>$scountry->id , 'course'=>$course->id])}}" class="btn btn-sm btn-success">{{__('Test your self')}}</a>
                                        </div>
                                    </div>

                                    @endif

                                    @endif


                                @endif


                                @else

                                <a class="flex {{$lesson->type == 0 ? '' : 'lesson_show'}}" href="{{$lesson->type == 0 ? route('lessons' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id , 'country'=>$scountry->id , 'course'=>$course->id]) : '#'}}">
                                    <span class="icon-holder icon-holder--small icon-holder--primary rounded-circle d-inline-flex icon--left">
                                        <i class="material-icons icon-16pt">{{$lesson->id == $slesson->id ? 'play_circle_filled' : 'play_circle_outline'}}</i>
                                    </span>
                                    {{ app()->getLocale() == 'ar' ? $lesson->name_ar : $lesson->name_en}}
                                </a>

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


                    <div class="col-md-12 text-right mb-3">
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


        @auth

            <input class="lesson_data" type="hidden"
            data-url="{{route('lessons.watch' , ['lang'=>app()->getLocale() , 'user'=>Auth::id()  , 'lesson'=>$slesson->id , 'country'=>$scountry->id , 'course'=>$course->id])}}"
            data-
            >

        @endauth






    </div>
</div>



@else

<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('You are not authorized to access this page') }}</div>
        </div>


        <div class="card text-center">
            <div class="card-header">
              {{__('You are not authorized to access this page')}}
            </div>
            <div class="card-body">
              <a href="{{ route('login' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id ]) }}" class="btn btn-primary">{{__('Go To Home Page')}}</a>
            </div>
          </div>

    </div>
</div>


@endif

@endsection


@push('scripts-front')

    <script>
        var file =
           "[Auto]{{ Storage::url('lessons/videos/' . $slesson->id . '/' . $slesson->id . '.m3u8') }}," +
            "[360]{{ Storage::url('lessons/videos/' . $slesson->id . '/' . $slesson->id . '_0_100.m3u8') }}," +
            "[480]{{ Storage::url('lessons/videos/' . $slesson->id . '/' . $slesson->id . '_1_250.m3u8') }}," +
            "[720]{{ Storage::url('lessons/videos/' . $slesson->id . '/' . $slesson->id . '_2_500.m3u8') }}";

        var player = new Playerjs({
            id: "player",
            file: file,
            poster: "{{ asset('storage/images/lessons/' . $slesson->image) }}",
            default_quality: "Auto",
        });


        var progress = $('.progress-bar').html();

        console.log(progress);

        if(progress == '100%'){
            $('.course-exam').css('display' , 'block');
        }


        let viewsCounted = false;
        let url = $('.lesson_data').data('url');
        let watched = $('.lesson_watched').data('watched');
        let id = $('.lesson_watched').data('id');

        console.log(watched);
        console.log('.test-div-'+id);

        function PlayerjsEvents(event, id, data) {
            if (event == "duration") {
                duration = data;
            }
            if (event == "time") {
                time = data;
            }
            let percent = (time / duration) * 100;
            if (percent > 80 && !viewsCounted) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function (data) {



                        if(watched == 0){
                            $('.test-div').css('display' , 'block')
                            $('.lesson_selected').append('<i style="color:#5edb15" class="fas fa-check"></i>');
                        }

                        $('.progress-bar').attr('aria-valuenow', data).css('width', data+'%').html(data+'%');

                        if(data == '100'){
                            $('.course-exam').css('display' , 'block');
                        }
                    },
                });//end of ajax call
                viewsCounted = true;
            } //end of if
        }//end of player event function


    </script>

@endpush
