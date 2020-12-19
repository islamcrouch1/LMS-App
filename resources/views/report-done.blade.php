@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('The complaint or suggestion has been sent successfully') }}</div>
        </div>


        <div class="card text-center">
            <div class="card-header">
              {{__('The complaint or suggestion has been sent successfully')}}
            </div>
            <div class="card-body">
            <h5 class="card-title">{{__('Thank you for contacting us')}}</h5>
              <p class="card-text">{{__('We will review your request and contact you as soon as possible')}}</p>
              <a href="{{route('home' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id])}}" class="btn btn-primary">{{__('Go To Home')}}</a>
            </div>
          </div>

    </div>
</div>



@endsection
