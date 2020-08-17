@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Social Links</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Social Links</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Social Links') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('settings.store' , app()->getLocale())}}" >
                        @csrf

                        @php
                            $social_sites = ['facebook' , 'youtube' , 'instagram'];
                        @endphp

                        @foreach ($social_sites as $social_site)
                        <div class="form-group row">
                            <label for="{{$social_site}}" class="col-md-2 col-form-label">{{ $social_site. ' ' . __('link') }}</label>

                            <div class="col-md-10">
                                <input id="{{$social_site}}" type="text" class="form-control" name="{{$social_site}}_link" value="{{ setting($social_site . '_link') }}" autofocus>
                            </div>
                        </div>
                        @endforeach



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>






  @endsection