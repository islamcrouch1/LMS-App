@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Terms and Conditions') }}</div>
        </div>

        <div class="row">
            <div class="col-md-12">

                @if (app()->getLocale() == 'ar')
                {!! setting('terms_ar') !!}
                @else
                {!! setting('terms_en') !!}
                @endif

            </div>
        </div>



    </div>
</div>



@endsection
