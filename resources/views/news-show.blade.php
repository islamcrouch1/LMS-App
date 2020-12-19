@extends('layouts.front.app')

@section('content')
<div class="page-section border-bottom-2">

    <div class="container page__container">

        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ app()->getLocale() == 'ar' ? $post->name_ar : $post->name_en }}</div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <img src="{{ asset('storage/' . $post->image) }}"
                alt="{{ app()->getLocale() == 'ar' ? $post->description_ar : $post->description_en}}"
                class="card-img"
                style="width: 50%">
            </div>
            <div class="col-md-12 mt-3">
                {!! app()->getLocale() == 'ar' ? $post->description_ar : $post->description_en !!}
            </div>
        </div>




    </div>

</div>


@endsection
