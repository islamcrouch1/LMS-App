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
                    <form method="POST" action="{{route('courses.update' , ['lang'=>app()->getLocale() , 'course'=>$course->id , 'ed_class'=>$ed_class->id , 'country'=>$country->id])}}" enctype="multipart/form-data">
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
                            <label for="description_ar" class="col-md-2 col-form-label">{{ __('An introductory profile in Arabic') }}</label>

                            <div class="col-md-10">
                                <textarea id="description_ar" type="text" class="form-control ckeditor @error('description_ar') is-invalid @enderror" name="description_ar"  autocomplete="description">{{ $course->description_ar }}</textarea>

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
                                <textarea id="description_en" type="text" class="form-control ckeditor @error('description_en') is-invalid @enderror" name="description_en"  autocomplete="description">{{ $course->description_en }}</textarea>

                                @error('description_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="course_price" class="col-md-2 col-form-label">{{ __('Course Price') }}</label>

                            <div class="col-md-10">
                                <input id="course_price" type="number" class="form-control @error('course_price') is-invalid @enderror" name="course_price" value="{{ $course->course_price  }}"  autocomplete="course_price">

                                @error('course_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="homework_price" class="col-md-2 col-form-label">{{ __('homework price') }}</label>

                            <div class="col-md-10">
                                <input id="homework_price" type="number" class="form-control @error('homework_price') is-invalid @enderror" name="homework_price" value="{{ $course->homework_price  }}"  autocomplete="homework_price">

                                @error('homework_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="teacher_commission" class="col-md-2 col-form-label">{{ __('teacher commision') }}</label>

                            <div class="col-md-10">
                                <input id="teacher_commission" type="number" class="form-control @error('teacher_commission') is-invalid @enderror" name="teacher_commission" value="{{ $course->teacher_commission }}"  autocomplete="teacher_commission">

                                @error('teacher_commission')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="homework_services" class="col-md-2 col-form-label">{{ __('Addon Homework Services') }}</label>
                            <div class="col-md-10">
                                <select style="height: 50px;" class=" select4 form-control @error('homework_services') is-invalid @enderror" name="homework_services[]" value="{{ old('homework_services') }}" multiple="multiple">


                                    @foreach ($country->homework_services as $homework_service)
                                    <option value="{{$homework_service->id}}" {{$course->homework_services()->where('homework_service_id', $homework_service->id)->first() != null ? 'selected' : ''}}>{{app()->getLocale() == 'ar' ?  $homework_service->name_ar . ' - ' . $homework_service->price  . $homework_service->country->currency : $homework_service->name_en . ' - ' . $homework_service->price . $homework_service->country->currency}}</option>
                                    @endforeach
                                </select>
                                @error('homework_services')
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
