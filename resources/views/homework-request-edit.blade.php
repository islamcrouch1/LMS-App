@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Edit Homework Request') }}</div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{route('homework-update', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id , 'homeworkRequest'=>$homeworkRequest->id]  )}}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="homework_title" class="col-md-2 col-form-label text-md-right">{{ __('Homework Title') }}</label>

                        <div class="col-md-10">
                            <input id="homework_title" type="text" class="form-control @error('homework_title') is-invalid @enderror" name="homework_title" value="{{ $homeworkRequest->homework_title }}" required autocomplete="homework_title" >

                            @error('homework_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="student_note" class="col-md-2 col-form-label">{{ __('Homework Notes') }}</label>

                        <div class="col-md-10">
                            <textarea id="student_note" type="text" class="form-control ckeditor @error('student_note') is-invalid @enderror" name="student_note"  autocomplete="description">{{ $homeworkRequest->student_note }}</textarea>

                            @error('student_note')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="student_image" class="col-md-2 col-form-label">{{ __('Edit Homework Image') }}</label>

                        <div class="col-md-10">
                            <input id="student_image" type="file" class="form-control-file img @error('student_image') is-invalid @enderror" name="student_image" value="{{ old('student_image') }}">

                            @error('student_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <img src="{{ asset('storage/images/homework/' . $homeworkRequest->student_image) }}" style="width:350px"  class="img-thumbnail img-prev">
                        </div>
                    </div>

                    <div class="form-group row down_link" >
                        <label for="student_file" class="col-md-2 col-form-label">{{ __('Edit Homework file') }}</label>

                        <div class="col-md-10">
                            <input id="student_file" type="file" class="form-control-file @error('student_file') is-invalid @enderror" name="student_file" value="{{ old('student_file') }}">

                            @error('student_file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    @if($homeworkRequest->student_file != '#' )


                    <div class="form-group row down_link">
                        <label for="down_link" class="col-md-2 col-form-label">{{ __('Download Uplouded File') }}</label>

                        <div class="col-md-10">
                            <a class="btn-info" style="padding: 10px; border-radius: 5px;" href="{{ asset('storage/homework/files/' . $homeworkRequest->student_file) }}">{{__('Download File')}}</a>
                        </div>
                    </div>

                    @endif



                    <div class="form-group row mb-0">
                        <div class="col-md-10 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Edit Your Request') }}
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>







    </div>
</div>



@endsection
