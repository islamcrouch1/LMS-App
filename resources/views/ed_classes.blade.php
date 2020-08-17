@extends('layouts.front.app')



@section('content')

<div class="container page__container">


<div class="page-separator pt-5 pb-5">
    <div class="page-separator__text">{{ app()->getLocale() == 'ar' ? $ed_class->name_ar : $ed_class->name_en}}</div>
</div>



<div class="row card-group-row">
 @foreach ($ed_class->courses as $course)
 <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal card-group-row__card"   data-force-reveal data-partial-height="44" data-toggle="popover" data-trigger="click">


        <a href="fixed-student-course.html" class="js-image" data-position="">
            <img style="width:100%" src="{{ asset('storage/' . $course->image) }}" alt="course-image">
            <span class="overlay__content align-items-start justify-content-start">
                <span class="overlay__action card-body d-flex align-items-center">
                    <i class="material-icons mr-4pt">play_circle_outline</i>
                    <span class="card-title text-white">Preview</span>
                </span>
            </span>
        </a>

        <div class="mdk-reveal__content">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex">
                        <a class="card-title" href="fixed-student-course.html">{{ app()->getLocale() == 'ar' ? $course->name_ar : $course->name_en}}</a>
                        <small class="text-50 font-weight-bold mb-4pt"></small>
                    </div>
                </div>
                {{-- <div class="d-flex">
                    <div class="rating flex">
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star</span></span>
                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                    </div>
                    <small class="text-50">6 hours</small>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="popoverContainer d-none">
        <div class="media">
            <div class="media-left mr-12pt">
                <img src="{{ asset('storage/' . $course->image) }}" width="40" height="40" alt="Angular" class="rounded">
            </div>
            <div class="media-body">
                <div class="card-title mb-0">{{ app()->getLocale() == 'ar' ? $course->name_ar : $course->name_en}}</div>
                {{-- <p class="lh-1 mb-0">
                    <span class="text-black-50 small">with</span>
                    <span class="text-black-50 small font-weight-bold">Elijah Murray</span>
                </p> --}}
            </div>
        </div>

        <p class="my-16pt text-black-70">{{ app()->getLocale() == 'ar' ? $course->description_ar : $course->description_en}}</p>

        {{-- <div class="mb-16pt">
            <div class="d-flex align-items-center">
                <span class="material-icons icon-16pt text-black-50 mr-8pt">check</span>
                <p class="flex text-black-50 lh-1 mb-0"><small>Fundamentals of working with Angular</small></p>
            </div>
            <div class="d-flex align-items-center">
                <span class="material-icons icon-16pt text-black-50 mr-8pt">check</span>
                <p class="flex text-black-50 lh-1 mb-0"><small>Create complete Angular applications</small></p>
            </div>
            <div class="d-flex align-items-center">
                <span class="material-icons icon-16pt text-black-50 mr-8pt">check</span>
                <p class="flex text-black-50 lh-1 mb-0"><small>Working with the Angular CLI</small></p>
            </div>
            <div class="d-flex align-items-center">
                <span class="material-icons icon-16pt text-black-50 mr-8pt">check</span>
                <p class="flex text-black-50 lh-1 mb-0"><small>Understanding Dependency Injection</small></p>
            </div>
            <div class="d-flex align-items-center">
                <span class="material-icons icon-16pt text-black-50 mr-8pt">check</span>
                <p class="flex text-black-50 lh-1 mb-0"><small>Testing with Angular</small></p>
            </div>
        </div> --}}


        <div class="row align-items-center">
            {{-- <div class="col-auto">
                <div class="d-flex align-items-center mb-4pt">
                    <span class="material-icons icon-16pt text-black-50 mr-4pt">access_time</span>
                    <p class="flex text-black-50 lh-1 mb-0"><small>6 hours</small></p>
                </div>
                <div class="d-flex align-items-center mb-4pt">
                    <span class="material-icons icon-16pt text-black-50 mr-4pt">play_circle_outline</span>
                    <p class="flex text-black-50 lh-1 mb-0"><small>12 lessons</small></p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="material-icons icon-16pt text-black-50 mr-4pt">assessment</span>
                    <p class="flex text-black-50 lh-1 mb-0"><small>Beginner</small></p>
                </div>
            </div> --}}
            <div class="col-md-6 text-right">
                <a href="#" class="btn btn-primary">{{__('Watch trailer')}}</a>
            </div>

            <div class="col-md-6 text-right">
                <a href="{{route('courses' , ['lang'=>app()->getLocale() , 'course'=>$course->id , 'country'=>$scountry->id])}}" class="btn btn-primary">{{__('Take Course')}}</a>
            </div>
        </div>



    </div>

</div>
 @endforeach




</div>

</div>




@endsection
