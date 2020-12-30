@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Send a complaint or suggestion') }}</div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{route('report.store', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id]  )}}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="service" class="col-md-2 col-form-label text-md-right">{{ __('Select the type of service') }}</label>

                        <div class="col-md-10">
                            <select class="form-control" id="status" name="service" required style="padding-bottom: 5px;">
                                    <option value="homework"> {{__('Request Homework service')}} </option>
                                    <option value="library"> {{__('Library Order')}} </option>
                                    <option value="course"> {{__('Buying educational courses')}} </option>
                            </select>

                            @error('service')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="details" class="col-md-2 col-form-label">{{ __('Write down your problem or suggestion in detail') }}</label>

                        <div class="col-md-10">
                            <textarea id="details" type="text" class="form-control ckeditor @error('details') is-invalid @enderror" name="details"  autocomplete="description"></textarea>

                            @error('details')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="report_image" class="col-md-2 col-form-label">{{ __('Upload Homework Image') }}</label>

                        <div class="col-md-10">
                            <input id="report_image" type="file" class="form-control-file img @error('report_image') is-invalid @enderror" name="report_image" value="{{ old('report_image') }}">

                            @error('report_image')
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
                            <img src="" style="width:350px"  class="img-thumbnail img-prev">
                        </div>
                    </div>

                    <div class="form-group row down_link" >
                        <label for="report_file" class="col-md-2 col-form-label">{{ __('Upload Homework file') }}</label>

                        <div class="col-md-10">
                            <input id="report_file" type="file" class="form-control-file @error('report_file') is-invalid @enderror" name="report_file" value="{{ old('report_file') }}">

                            @error('report_file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group row mb-0">
                        <div class="col-md-10 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Your Request') }}
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>







    </div>
</div>



@endsection
