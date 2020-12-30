@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>posts</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">posts</li>
                <li class="breadcrumb-item active">Edit posts</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add posts') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('posts.update' , ['lang'=>app()->getLocale() , 'post'=>$post->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name_ar" class="col-md-2 col-form-label">{{ __('Arabic Name') }}</label>

                            <div class="col-md-10">
                            <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" value="{{$post->name_ar}}"  autocomplete="name" autofocus>

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
                                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{$post->name_en}}"  autocomplete="name" autofocus>

                                @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description_ar" class="col-md-2 col-form-label">{{ __('An introductory profile in Arabic') }}</label>

                            <div class="col-md-10">
                                <textarea id="description_ar" type="text" class="form-control ckeditor @error('description_ar') is-invalid @enderror" name="description_ar"  autocomplete="description">{{ $post->description_ar }}</textarea>

                                @error('description_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description_en" class="col-md-2 col-form-label">{{ __('An introductory profile in English') }}</label>

                            <div class="col-md-10">
                                <textarea id="description_en" type="text" class="form-control ckeditor @error('description_en') is-invalid @enderror" name="description_en"  autocomplete="description">{{ $post->description_en }}</textarea>

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
                                @if (auth()->user()->hasRole('superadministrator') || auth()->user()->monitor->countries()->where('country_id', $country->id)->first() != null )
                                <option value="{{ $country->id }}" {{$post->country->id == $country->id ? 'selected' : ''}} >{{ $country->name_en }}</option>
                                @endif
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
                            <label for="image" class="col-md-2 col-form-label">{{ __('image') }}</label>

                            <img class="img-thumbnail" style="width:50%" src="{{ asset('storage/' . $post->image) }}">

                            <div class="col-md-10 pt-4">
                                <input id="image" type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>






                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edit post') }}
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
