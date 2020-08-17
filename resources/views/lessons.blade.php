@extends('layouts.front.app')



@section('content')



{{-- <div class="page-separator pt-5 pb-5">
    <div class="page-separator__text">{{ app()->getLocale() == 'ar' ? $lesson->name_ar : $lesson->name_en}}</div>
</div> --}}


<div class="bg-primary pb-lg-64pt py-32pt">
    <div class="container page__container">


    <div class="d-flex flex-wrap align-items-end mb-16pt">
        <h1 class="text-white flex m-0">{{ app()->getLocale() == 'ar' ? $lesson->name_ar : $lesson->name_en}}</h1>
        {{-- <p class="h1 text-white-50 font-weight-light m-0">50:13</p> --}}
    </div>

    <p class="hero__lead measure-hero-lead text-white-50 mb-24pt">{{ app()->getLocale() == 'ar' ? $lesson->description_ar : $lesson->description_en}}</p>
    <div class="container page__container">
  
                <div id="player"></div>
 


            </div>

    </div>
</div>



@endsection


@push('scripts-front')

    <script>
        var file =
           "[Auto]{{ Storage::url('lessons/videos/' . $lesson->id . '/' . $lesson->id . '.m3u8') }}," +
            "[360]{{ Storage::url('lessons/videos/' . $lesson->id . '/' . $lesson->id . '_0_100.m3u8') }}," +
            "[480]{{ Storage::url('lessons/videos/' . $lesson->id . '/' . $lesson->id . '_1_250.m3u8') }}," +
            "[720]{{ Storage::url('lessons/videos/' . $lesson->id . '/' . $lesson->id . '_2_500.m3u8') }}";

        var player = new Playerjs({
            id: "player",
            file: file,
            poster: "{{ asset('storage/images/lessons/' . $lesson->image) }}",
            default_quality: "Auto",
        });


    </script>

@endpush