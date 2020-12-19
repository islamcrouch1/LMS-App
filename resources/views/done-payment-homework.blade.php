@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Order Done') }}</div>
        </div>


        <div class="card text-center">
            <div class="card-header alert alert-success">
                {{ __('Order Done') }}
            </div>
            <div class="card-body">
            <h5 class="card-title">{{__('Thank you for completing your order')}}</h5>
              <p class="card-text">{{__('Dear student, you can start using the help service in solving your homework, go now to the homework page and contact your teacher')}}</p>
              <a href="{{route('homework' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id])}}" class="btn btn-primary">{{__('Go To Homework Page')}}</a>
            </div>
          </div>

    </div>
</div>



@endsection
