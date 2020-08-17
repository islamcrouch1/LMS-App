@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Courses</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Courses</li>
                <li class="breadcrumb-item active">Edit Courses</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add Courses') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('courses.update' , ['lang'=>app()->getLocale() , 'course'=>$course->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name_ar" class="col-md-2 col-form-label">{{ __('Arabic Name') }}</label>

                            <div class="col-md-10">
                            <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" value="{{$course->name_ar}}"  autocomplete="name" autofocus>

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
                                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{$course->name_en}}"  autocomplete="name" autofocus>

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
                                <input id="description_ar" type="text" class="form-control @error('description_ar') is-invalid @enderror" name="description_ar" value="{{ $course->description_ar }}"  autocomplete="description">

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
                                <input id="description_en" type="text" class="form-control @error('description_en') is-invalid @enderror" name="description_en" value="{{ $course->description_ar }}"  autocomplete="description">

                                @error('description_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        


                        <div class="form-group row">
                            <label for="ed_class" class="col-md-2 col-form-label">{{ __('Learning System select') }}</label>
                            <div class="col-md-10">
                                <select class="form-control @error('ed_class') is-invalid @enderror" id="ed_class" name="ed_class_id" value="{{ old('ed_class') }}" required autocomplete="ed_class">
                                @foreach ($ed_classes as $ed_class)
                                <option value="{{ $ed_class->id }}" {{$course->ed_class->id == $ed_class->id ? 'selected' : ''}}>{{ $ed_class->name_en }}</option>
                                @endforeach
                                </select>
                                @error('ed_class')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="image" class="col-md-2 col-form-label">{{ __('image') }}</label>

                            <img class="img-thumbnail" style="width:50%" src="{{ asset('storage/' . $course->image) }}">

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
                                    {{ __('Edit Course') }}
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