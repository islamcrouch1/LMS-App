@extends('layouts.front.app')



@section('content')

<div class="container page__container">


<div class="page-separator pt-5 pb-5">
    <div class="page-separator__text">{{ app()->getLocale() == 'ar' ? $course->name_ar : $course->name_en}}</div>
</div>



<div class="row mb-0">
    <div class="col-lg-7">


        <div class="accordion js-accordion accordion--boxed list-group-flush" id="parent">
            <div class="accordion__item">
                <a href="#" class="accordion__toggle collapsed" data-toggle="collapse" data-target="#course-toc-1" data-parent="#parent">
                    <span class="flex">{{ app()->getLocale() == 'ar' ? $course->name_ar : $course->name_en}} - ({{__('Course Description')}})</span>
                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                </a>
                <div class="accordion__menu collapse" id="course-toc-1">
                    <div class="accordion__menu-link">
                        <p>{{ app()->getLocale() == 'ar' ? $course->description_ar : $course->description_en}}</p>
                    </div>
                </div>
            </div>

            @foreach ($course->chapters as $chapter)
            <div class="accordion__item">
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
                        <a class="flex" href="{{route('lessons' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id , 'country'=>$scountry->id])}}">{{ app()->getLocale() == 'ar' ? $lesson->name_ar : $lesson->name_en}}</a>
                        {{-- <span class="text-muted">50m 13s</span> --}}
                    </div>
                    @endforeach


                </div>
            </div>
            @endforeach

        </div>

    </div>
    {{-- <div class="col-lg-5 justify-content-center">


        <div class="card">
            <div class="card-body py-16pt text-center">
                <span class="icon-holder icon-holder--outline-secondary rounded-circle d-inline-flex mb-8pt">
                    <i class="material-icons">timer</i>
                </span>
                <h4 class="card-title"><strong>Unlock Library</strong></h4>
                <p class="card-subtitle text-70 mb-24pt">Get access to all videos in the library</p>
                <a href="fixed-pricing.html" class="btn btn-accent mb-8pt">Sign Up - Only $19.00/mo</a>
                <p class="mb-0">Have an account? <a href="fixed-login.html">Login</a></p>
            </div>
        </div>

    </div> --}}
</div>
</div>
</div>



</div>

@endsection
