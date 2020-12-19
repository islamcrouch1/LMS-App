@extends('layouts.front.app')

@section('content')
<div class="page-section border-bottom-2">

    <div class="container page__container">

        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Latest News') }}</div>
        </div>



        <div class="row card-group-row" >


            @foreach ($posts as $post)

                <div class="col-md-6 col-lg-4 card-group-row__col">


                    <div class="card card--elevated posts-card-popular overlay card-group-row__card">
                        <img src="{{ asset('storage/' . $post->image) }}"
                            alt="{{ app()->getLocale() == 'ar' ? $post->description_ar : $post->description_en}}"
                            class="card-img">
                        <div class="fullbleed bg-primary"
                            style="opacity: .2"></div>
                        <div class="posts-card-popular__content" style="z-index: 1000000001 !important">
                            <div class="posts-card-popular__title card-body">
                                <a class="card-title post-products"
                                href="{{route('news.show' , ['lang' => app()->getLocale() , 'country' => $scountry->id , 'post'=>$post->id])}}"
                                >{{ app()->getLocale() == 'ar' ? $post->name_ar : $post->name_en}}</a>
                            </div>
                        </div>
                    </div>




                </div>
            @endforeach



        </div>
        <div class="row mt-3"> {{ $posts->appends(request()->query())->links() }}</div>



    </div>

</div>


@endsection
