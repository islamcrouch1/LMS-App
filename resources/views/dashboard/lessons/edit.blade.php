@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Lessons</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Lessons</li>
                <li class="breadcrumb-item active">Edit Lessons</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add Lessons') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('lessons.update' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id , 'country'=>$country->id , 'chapter' => $chapter->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name_ar" class="col-md-2 col-form-label">{{ __('Arabic Name') }}</label>

                            <div class="col-md-10">
                            <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" value="{{$lesson->name_ar}}"  autocomplete="name" autofocus>

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
                                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{$lesson->name_en}}"  autocomplete="name" autofocus>

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
                                <textarea id="description_ar" type="text" class="form-control ckeditor @error('description_ar') is-invalid @enderror" name="description_ar"  autocomplete="description">{{ $lesson->description_ar }}</textarea>

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
                                <textarea id="description_en" type="text" class="form-control ckeditor @error('description_en') is-invalid @enderror" name="description_en"  autocomplete="description">{{ $lesson->description_en }}</textarea>

                                @error('description_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="type" class="col-md-2 col-form-label">{{ __('Lesson Type') }}</label>

                            <div class="col-md-10">

                                <select class="custom-select my-1 mr-sm-2 @error('type') is-invalid @enderror" id="inlineFormCustomSelectPref" id="type" name="type" value="{{ old('type') }}" required>
                                    <option value="1" {{ $lesson->type == 1 ? 'selected' : ''}}>{{__('Paid')}}</option>
                                    <option value="0" {{ $lesson->type == 0 ? 'selected' : ''}}>{{__('Free')}}</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row down_link" >
                            <label for="lesson_file" class="col-md-2 col-form-label">{{ __('Edit Homework file') }}</label>

                            <div class="col-md-10">
                                <input id="lesson_file" type="file" class="form-control-file @error('lesson_file') is-invalid @enderror" name="lesson_file" value="{{ old('lesson_file') }}">

                                @error('lesson_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if($lesson->lesson_file != '#' )


                        <div class="form-group row down_link">
                            <label for="down_link" class="col-md-2 col-form-label">{{ __('Download Lesson File') }}</label>

                            <div class="col-md-10">
                                <a class="btn-info" style="padding: 10px; border-radius: 5px;" href="{{ asset('storage/lessons/files/' . $lesson->lesson_file) }}">{{__('Download File')}}</a>
                            </div>
                        </div>

                        @endif



                        <div class="form-group row">
                            <label for="image" class="col-md-2 col-form-label">{{ __('image') }}</label>

                            <img class="img-thumbnail" style="width:50%" src="{{ asset('storage/images/lessons/' . $lesson->image) }}">

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
                                    {{ __('Edit Lesson') }}
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
