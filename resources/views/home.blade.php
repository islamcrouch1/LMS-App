@extends('layouts.front.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection


@section('welcomContent')
<div class="container page__container">

    <div class="hero container page__container text-center text-md-left py-112pt">
        <h1 class="text-white text-shadow">{{__('Start Learning Now')}}</h1>
        <p class="lead measure-hero-lead mx-auto mx-md-0 text-white text-shadow mb-48pt">{{__('The easiest way to learn for all educational levels, as well as specialized courses and courses in all fields')}}</p>

        @foreach ($scountry->learning_systems as $learning_system)
        <a href="{{route('learning_systems' , ['lang'=>app()->getLocale() , 'learning_system'=>$learning_system->id , 'country'=>$scountry->id])}}" class="btn btn-lg btn-white btn--raised mb-16pt">{{ app()->getLocale() == 'ar' ? $learning_system->name_ar : $learning_system->name_en}}</a>
        @endforeach


        <p class="mb-0"><a href="" class="text-white text-shadow"><strong>{{__('Are you a teacher?')}}</strong></a></p>

    </div>

</div>
@endsection
