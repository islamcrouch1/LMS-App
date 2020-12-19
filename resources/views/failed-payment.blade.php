@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Failed Payent') }}</div>
        </div>


        <div class="card text-center">
            <div class="card-header alert alert-danger">
              {{__('Failed Payent')}}
            </div>
            <div class="card-body">
            <h5 class="card-title">{{__('Something went wrong')}}</h5>
              <p class="card-text">{{__('An error occurred during the payment process, please try again later')}}</p>
              <a href="{{route('home' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id])}}" class="btn btn-primary">{{__('Go To Home')}}</a>
            </div>
          </div>

    </div>
</div>



@endsection
