@extends('layouts.dashboard.app')


@push('style')

<style>

    #video_input_wrapper{
        height:25vh;
        border:1px solid black;
        cursor:pointer;
        display:flex;
        justify-content:center;
        align-items:center;
        margin:10px;
    }

</style>

@endpush

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
                <li class="breadcrumb-item active">Add New Lessons</li>
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



                <div class="flex-column"
                id="video_input_wrapper"
                onclick="document.getElementById('video_input_file').click()"
                style="display:{{ $errors->any() ? 'none' : 'flex'}};"
                >

                    <i class="fa fa-camera fa-2x"></i>
                    <p>Click To Uploud Video</p>
                </div>
                <input type="file" data-local="{{app()->getLocale()}}" data-url="{{route('lessons.store', ['lang'=> app()->getLocale() , 'country'=>$country->id , 'chapter'=>$chapter->id]  )}}" data-lesson-id="{{$lesson->id}}" id="video_input_file" name="" style="display:none;">


                <div class="card-body">
                    <form id="lesson_form" method="POST" action="{{route('lessons.store', ['lang'=> app()->getLocale() , 'country'=>$country->id , 'chapter'=>$chapter->id]  )}}" enctype="multipart/form-data" style="display:{{ $errors->any() ? 'block' : 'none'}};">
                        @csrf




                        <div class="form-group row" style="display:{{ $errors->any() ? 'none' : ''}};">
                            <label id="lesson-status" class="col-md-2 col-form-label">{{ __('Uplouding....') }}</label>

                            <div class="col-md-10">
                                <div class="progress  mt-2" >
                                    <div id="video_progress" class="progress-bar" role="progressbar"></div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row" style="display:none">
                            <div class="col-md-10">
                                <input id="lesson_id" type="text" class="form-control" name="lesson_id" value="{{ $lesson->id }}"  autocomplete="name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label id="lesson_name" for="name_ar" class="col-md-2 col-form-label">{{ __('Arabic Name') }}</label>

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
                                <textarea id="description_ar" type="text" class="form-control ckeditor @error('description_ar') is-invalid @enderror" name="description_ar" value="{{ old('description_ar') }}"  autocomplete="description"></textarea>

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
                                <textarea id="description_en" type="text" class="form-control ckeditor @error('description_en') is-invalid @enderror" name="description_en" value="{{ old('description_en') }}"  autocomplete="description"></textarea>

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
                                    <option value="1" {{ old('type') == 1 ? 'selected' : ''}}>{{__('Paid')}}</option>
                                    <option value="0" {{ old('type') == 0 ? 'selected' : ''}}>{{__('Free')}}</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row down_link" >
                            <label for="lesson_file" class="col-md-2 col-form-label">{{ __('Upload Homework file') }}</label>

                            <div class="col-md-10">
                                <input id="lesson_file" type="file" class="form-control-file @error('lesson_file') is-invalid @enderror" name="lesson_file" value="{{ old('lesson_file') }}">

                                @error('lesson_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="image" class="col-md-2 col-form-label">{{ __('image') }}</label>

                            <div class="col-md-10">
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
                                <button id="lesson_submit" style="display:{{ $errors->any() ? 'block' : 'none'}};" type="submit" class="btn btn-primary">
                                    {{ __('Add New Lesson') }}
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
