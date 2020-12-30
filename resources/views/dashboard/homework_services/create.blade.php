@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('Homework Services')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">{{__('Homework Services')}}</li>
                <li class="breadcrumb-item active">{{__('Add New Homework Service')}}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add New Homework Service') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('homework_services.store', ['lang'=> app()->getLocale()])}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name_ar" class="col-md-2 col-form-label">{{ __('Arabic Name') }}</label>

                            <div class="col-md-10">
                                <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" value="{{ old('name_ar') }}"  autocomplete="name" autofocus>

                                @error('name_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name_en" class="col-md-2 col-form-label">{{ __('English Name') }}</label>

                            <div class="col-md-10">
                                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{ old('name_en') }}"  autocomplete="name" autofocus>

                                @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description_ar" class="col-md-2 col-form-label">{{ __('Arabic Description') }}</label>

                            <div class="col-md-10">
                                <input id="description_ar" type="text" class="form-control @error('description_ar') is-invalid @enderror" name="description_ar" value="{{ old('description_ar') }}"  autocomplete="description">

                                @error('description_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description_en" class="col-md-2 col-form-label">{{ __('English Description') }}</label>

                            <div class="col-md-10">
                                <input id="description_en" type="text" class="form-control @error('description_en') is-invalid @enderror" name="description_en" value="{{ old('description_en') }}"  autocomplete="description">

                                @error('description_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="country" class="col-md-2 col-form-label">{{ __('Country select') }}</label>
                            <div class="col-md-10">
                                <select class=" form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}" required autocomplete="country">
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}" >{{ $country->name_en }}</option>
                                @endforeach
                                </select>
                                @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="price" class="col-md-2 col-form-label">{{ __('Price') }}</label>

                            <div class="col-md-10">
                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}"  autocomplete="price">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="teacher_commission" class="col-md-2 col-form-label">{{ __('Teacher Commission') }}</label>

                            <div class="col-md-10">
                                <input id="teacher_commission" type="number" class="form-control @error('teacher_commission') is-invalid @enderror" name="teacher_commission" value="{{ old('teacher_commission') }}"  autocomplete="teacher_commission">

                                @error('teacher_commission')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add New Homework Service') }}
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
