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


            @if (App\Post::all()->count() > 3)
            <div class="col-md-6 col-lg-4 card-group-row__col">
                <a class="btn btn-primary" href="{{route('news' , ['lang' => app()->getLocale() , 'country' => $scountry->id])}}">{{__('See All News')}}</a>
            </div>
            @endif

        </div>



    </div>

</div>




<div class="page-section border-bottom-2">

    <div class="container page__container">

        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Advertisement') }}</div>
        </div>


        <div class="row card-group-row" >

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($ads as $ad)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($ads as $ad)
                    <div class="carousel-item {{ $loop->first ? ' active' : '' }}">
                        <a href="{{ $ad->url}}" target="_blank">
                            <img class="d-block w-100" src="{{ asset('storage/' . $ad->image) }}" alt="{{ app()->getLocale() == 'ar' ? $ad->name_ar : $ad->name_en}}">
                            <div class="carousel-caption d-none d-md-block">
                                <p>{{ app()->getLocale() == 'ar' ? $ad->name_ar : $ad->name_en}}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>


        </div>



    </div>

</div>


<div class="page-section border-bottom-2">

    <div class="container page__container">

        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Sponsers') }}</div>
        </div>


        <div class="row card-group-row" >

            @php
                $sponsers =   array_chunk($sponsers->toArray(), 3);
            @endphp

            <div id="carouselExampleIndicatorss" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($sponsers as $asponsers)
                    <li data-target="#carouselExampleIndicatorss" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($sponsers as $asponsers)
                    <div class="carousel-item {{ $loop->first ? ' active' : '' }}">
                        @foreach ($asponsers as $sponser)
                        <a href="{{ $sponser['url']}}" target="_blank">
                            <img style="width:33% !important;" class="" src="{{ asset('storage/' . $sponser['image']) }}" alt="{{ app()->getLocale() == 'ar' ? $sponser['name_ar'] : $sponser['name_en']}}">
                            <div class="carousel-caption d-none">
                                <p>{{ app()->getLocale() == 'ar' ? $sponser['name_ar'] : $sponser['name_en']}}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicatorss" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicatorss" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>


        </div>



    </div>

</div>






@endsection


@section('welcomContent')
<div class="container page__container">

    <div class="hero container page__container text-center text-md-left py-112pt">
        <h1 class="text-white text-shadow">{{__('Start Learning Now')}}</h1>
        <p class="lead measure-hero-lead mx-auto mx-md-0 text-white text-shadow mb-48pt">{{__('The easiest way to learn for all educational levels, as well as specialized courses and courses in all fields')}}</p>

        @foreach ($scountry->learning_systems as $learning_system)
        <a href="{{route('learning_systems' , ['lang'=>app()->getLocale() , 'learning_system'=>$learning_system->id , 'country'=>$scountry->id])}}" class="btn btn-lg btn-white btn--raised mb-16pt">{{ app()->getLocale() == 'ar' ? $learning_system->name_ar : $learning_system->name_en}}</a>
        @endforeach
        <a href="{{route('teachers' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id])}}" class="btn btn-lg btn-white btn--raised mb-16pt">{{ __('Teachers') }}</a>

        <a href="{{route('library' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id])}}" class="btn btn-lg btn-white btn--raised mb-16pt">{{ __('Library') }}</a>

        <p class="mb-0"><a href="{{ route('register' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id ]) }}" class="text-white text-shadow"><strong>{{__('Are you a teacher?')}}</strong></a></p>

    </div>

</div>


<div class="border-bottom-2 py-16pt navbar-light bg-white border-bottom-2">
    <div class="container page__container">
        <div class="row align-items-center">
            <div class="d-flex col-md align-items-center border-bottom border-md-0 mb-16pt mb-md-0 pb-16pt pb-md-0">
                <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                    <i class="material-icons text-white">subscriptions</i>
                </div>
                <div class="flex">
                    <div class="card-title mb-4pt">{{__('8,000+ Courses')}}</div>
                    <p class="card-subtitle text-70">{{ __('Explore a wide range of skills.')}}</p>
                </div>
            </div>
            <div class="d-flex col-md align-items-center border-bottom border-md-0 mb-16pt mb-md-0 pb-16pt pb-md-0">
                <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                    <i class="material-icons text-white">verified_user</i>
                </div>
                <div class="flex">
                    <div class="card-title mb-4pt">{{__('By Industry Experts')}}</div>
                    <p class="card-subtitle text-70">{{__('Professional development from the best people.')}}</p>
                </div>
            </div>
            <div class="d-flex col-md align-items-center">
                <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                    <i class="material-icons text-white">update</i>
                </div>
                <div class="flex">
                    <div class="card-title mb-4pt">{{__('Unlimited Access')}}</div>
                    <p class="card-subtitle text-70">{{__('Unlock Library and learn any topic with one subscription.')}}</p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
