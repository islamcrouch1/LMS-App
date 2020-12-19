@extends('layouts.front.app')



@section('content')


            @if (Auth::user()->course_orders->where('course_id' , $course->id)->where('status' , 'done')->count() > 0 || $slesson->type == 0)


            <!-- Header Layout Content -->
            <div class="mdk-header-layout__content page-content ">

                <div class="navbar navbar-list navbar-light bg-white border-bottom-2 border-bottom navbar-expand-sm"
                     style="white-space: nowrap;">
                    <div class="container page__container">
                        <nav class="nav navbar-nav">
                            <div class="nav-item navbar-list__item">
                                @if ($exam_result->exam->lesson_id != null)
                                <a href="{{route('lessons' , ['lang'=>app()->getLocale() , 'lesson'=>$exam_result->exam->lesson_id  , 'country'=>$scountry->id , 'course'=>$course->id])}}"
                                   class="nav-link h-auto"><i class="material-icons icon--left">keyboard_backspace</i> {{__('Back to Lesson')}}</a>
                                @else
                                <a href="{{route('courses' , ['lang'=>app()->getLocale() , 'course'=>$course->id , 'country'=>$scountry->id])}}"
                                    class="nav-link h-auto"><i class="material-icons icon--left">keyboard_backspace</i> {{__('Back to Course')}}</a>
                                @endif
                            </div>
                        </nav>
                    </div>
                </div>


                <div class="mdk-box bg-primary mdk-box--bg-gradient-primary2 js-mdk-box mb-0"
                     data-effects="blend-background">
                    <div class="mdk-box__content">
                        <div class="py-64pt text-center text-sm-left">
                            <div class="container d-flex flex-column justify-content-center align-items-center">
                                <p class="lead text-white-50 measure-lead-max mb-0">{{__('Submited on : ') . $exam_result->created_at}} </p>
                                <h1 class="text-white mb-24pt">{{__('you passed the exam by : ') . '%' . $exam_result->result }}</h1>
                                <a href="{{ route('exam.questions' , ['lang'=>app()->getLocale() ,'lesson'=>$exam_result->exam->lesson_id , 'exam'=>$exam_result->exam->id , 'user'=>Auth::id() , 'country'=>$scountry->id , 'course'=>$course->id])}}"
                                   class="btn btn-outline-white">{{__('Restart Exam')}}</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- // END Header Layout Content -->
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
