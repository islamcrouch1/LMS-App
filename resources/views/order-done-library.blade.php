@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Order Done') }}</div>
        </div>


        <div class="card text-center">
            <div class="card-header">
              {{__('Done')}}
            </div>
            <div class="card-body">
            <h5 class="card-title pb-2">{{__('Thank you for completing your order')}}</h5>
              <a href="{{route('my-orders' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}" class="btn btn-primary">{{__('Go To Your Orders Page')}}</a>
            </div>
          </div>

    </div>
</div>



@endsection
