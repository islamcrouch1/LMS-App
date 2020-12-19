@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Learning Systems')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{__('Learning Systems')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('All Learning Systems For All Countries') }}</div>

                    <div class="card-body">
                        <div class="row">


                        @foreach ($countries as $country)

                        <div class="col-md-4">
                            <!-- Widget: user widget style 1 -->
                            <div class="card card-widget widget-user">
                              <!-- Add the bg color to the header using any of the bg-* classes -->
                              <div class="widget-user-header bg-info">
                                <a href="{{route('learning_systems.index' , ['lang'=>app()->getLocale() , 'country'=>$country->id])}}">
                                    <h3 class="widget-user-username">{{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en}}</h3>
                                </a>
                              </div>
                              <a href="{{route('learning_systems.index' , ['lang'=>app()->getLocale() , 'country'=>$country->id])}}">
                                <div class="widget-user-image">
                                        <img class="img-circle elevation-2" src="{{ asset('storage/' . $country->image) }}" alt="User Avatar">
                                </div>
                              </a>
                              <div class="card-footer">
                                <div class="row">
                                  <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                      <h5 class="description-header">3,200</h5>
                                      <span class="description-text">SALES</span>
                                    </div>
                                    <!-- /.description-block -->
                                  </div>
                                  <!-- /.col -->
                                  <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                      <h5 class="description-header">13,000</h5>
                                      <span class="description-text">FOLLOWERS</span>
                                    </div>
                                    <!-- /.description-block -->
                                  </div>
                                  <!-- /.col -->
                                  <div class="col-sm-4">
                                    <div class="description-block">
                                      <h5 class="description-header">35</h5>
                                      <span class="description-text">PRODUCTS</span>
                                    </div>
                                    <!-- /.description-block -->
                                  </div>
                                  <!-- /.col -->
                                </div>
                                <!-- /.row -->
                              </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->
                        @endforeach
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>













@endsection
