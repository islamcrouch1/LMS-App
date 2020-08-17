@extends('layouts.app')




@section('welcomContent')
    <div class="hero container page__container text-center text-md-left py-112pt">
        <h1 class="text-white text-shadow">{{__('Start Learning Now')}}</h1>
        <p class="lead measure-hero-lead mx-auto mx-md-0 text-white text-shadow mb-48pt">{{__('The easiest way to learn for all educational levels, as well as specialized courses and courses in all fields')}}</p>

        @foreach ($scountry->learning_systems as $learning_system)
        <a href="{{route('learning_systems' , ['lang'=>app()->getLocale() , 'learning_system'=>$learning_system->id , 'country'=>$scountry->id])}}" class="btn btn-lg btn-white btn--raised mb-16pt">{{ app()->getLocale() == 'ar' ? $learning_system->name_ar : $learning_system->name_en}}</a>
        @endforeach
        <a href="" class="dropdown-item"></a>


        <p class="mb-0"><a href="" class="text-white text-shadow"><strong>{{__('Are you a teacher?')}}</strong></a></p>

    </div>
@endsection