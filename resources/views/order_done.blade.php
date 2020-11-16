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
            <h5 class="card-title">{{__('Thank you for completing your order')}}</h5>
              <p class="card-text">{{__('you can track your arder and review all previos orders from your order page')}}</p>
              <a href="#" class="btn btn-primary">{{__('Go To Your Orders Page')}}</a>
            </div>
          </div>

    </div>
</div>



@endsection
