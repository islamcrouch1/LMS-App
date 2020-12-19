@extends('layouts.front.app')



@section('content')


<div style="" class="page-section">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('My Courses') }}</div>
        </div>

        @php
            $CoursesCount = 0 ;
        @endphp

        @foreach ($user->course_orders->reverse() as $courseOrder)
        @if ($courseOrder->status == 'done')
            @php
                $CoursesCount = $CoursesCount + 1 ;
            @endphp
        @endif
        @endforeach

        @if ($user->course_orders->count() == 0 || $CoursesCount == 0)

        <div style="padding:20px" class="row">
            <div class="col-md-6 pt-3">
                <h6>{{__('No courses in your account ..! Go to the Home page and choose your course to help you with your study')}}</h6>
            </div>
        </div>
        @else



        <div class="card mb-lg-32pt">

            <div class="table-responsive">


                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>
                                {{__('Course')}}
                            </th>

                            <th>
                                {{__('Course Progress')}}
                            </th>
                            <th>
                                {{__('Exam')}}
                            </th>
                            <th>
                                {{__('Course Exam Percentage')}}
                            </th>
                            <th>
                                {{__('Watch Course')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list order-list">

                        @foreach ($user->course_orders->reverse() as $courseOrder)
                        @if ($courseOrder->status == 'done')
                        <tr>
                            <td style="">{{ app()->getLocale() == 'ar' ? $courseOrder->course->name_ar : $courseOrder->course->name_en}}</td>



                            <td style="">
                                @php

                                $average = 0 ;
                                $watched_count = 0 ;
                                $sum = 0 ;

                                foreach ($user->user_lessons->where('course_id' , $courseOrder->course->id) as $user_lesson) {
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
                            </td>

                            <td style="">

                                <div style="display:none" class="row course-exam">
                                    <div class="col-md-12">
                                        <a href="{{ route('exam.questions' , ['lang'=>app()->getLocale() ,'lesson'=>'#' , 'exam'=>$courseOrder->course->exam->id , 'user'=>Auth::id() , 'country'=>$scountry->id , 'course'=>$courseOrder->course->id])}}" class="btn btn-sm btn-primary">{{__('Full course exam')}}</a>
                                    </div>
                                </div>


                                <div style="display:none" class="row course-exam-no">
                                    <div class="col-md-12">
                                        <p>{{__('Complete the course to be able to start the test')}}</p>
                                    </div>
                                </div>

                            </td>

                            @php
                                    $exam_result = App\ExamUser::where('exam_id' , $courseOrder->course->exam->id)->where('user_id' , $user->id)->first();
                            @endphp


                            @if (App\ExamUser::where('exam_id' , $courseOrder->course->exam->id)->where('user_id' , $user->id)->first() == null)
                                <td style=""><span class="badge badge-success badge-lg"> {{__('You have not passed the test yet')}} <span></td>
                            @else
                                @php
                                    $exam_result = App\ExamUser::where('exam_id' , $courseOrder->course->exam->id)->where('user_id' , $user->id)->first();
                                @endphp
                                <td style=""><span class="badge badge-success badge-lg"> {{$exam_result->result . '%' }} <span></td>
                            @endif


                            <td style="">
                                <a href="{{route('courses' , ['lang'=>app()->getLocale() , 'course'=>$courseOrder->course->id , 'country'=>$scountry->id])}}" style="color:#fff;" class="btn btn-primary btn-sm">
                                    <i class="fa fa-video"></i>
                                    {{__('Watch Course')}}

                                </a>
                            </td>


                        </tr>
                        @endif
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>





    @endif




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
    }else{
        $('.course-exam-no').css('display' , 'block');
    }



});


</script>

@endpush
