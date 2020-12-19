@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>questions</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">questions</li>
                <li class="breadcrumb-item active">Edit questions</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Edit questions') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('questions.update' , ['lang'=>app()->getLocale() , 'question'=>$question->id , 'exam'=>$exam->id , 'country'=>$country->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="question" class="col-md-2 col-form-label">{{ __('Question') }}</label>

                            <div class="col-md-10">
                                <input id="question" type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ $question->question }}"  autocomplete="question" autofocus>

                                @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="answer1" class="col-md-2 col-form-label">{{ __('Answer 1') }}</label>

                            <div class="col-md-10">
                                <input id="answer1" type="text" class="form-control @error('answer1') is-invalid @enderror" name="answer1" value="{{ $question->answer1 }}"  autocomplete="answer1" autofocus>

                                @error('answer1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="answer2" class="col-md-2 col-form-label">{{ __('Answer 2') }}</label>

                            <div class="col-md-10">
                                <input id="answer2" type="text" class="form-control @error('answer2') is-invalid @enderror" name="answer2" value="{{  $question->answer2  }}"  autocomplete="answer2" autofocus>

                                @error('answer2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="answer3" class="col-md-2 col-form-label">{{ __('Answer 3') }}</label>

                            <div class="col-md-10">
                                <input id="answer3" type="text" class="form-control @error('answer3') is-invalid @enderror" name="answer3" value="{{  $question->answer3 }}"  autocomplete="answer3" autofocus>

                                @error('answer3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="answer4" class="col-md-2 col-form-label">{{ __('Answer 4') }}</label>

                            <div class="col-md-10">
                                <input id="answer4" type="text" class="form-control @error('answer4') is-invalid @enderror" name="answer4" value="{{  $question->answer4  }}"  autocomplete="answer4" autofocus>

                                @error('answer4')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="true_answer" class="col-md-2 col-form-label">{{ __('True Answer') }}</label>

                            <div class="col-md-10">

                                <select class="custom-select my-1 mr-sm-2 @error('true_answer') is-invalid @enderror" id="inlineFormCustomSelectPref" id="true_answer" name="true_answer" value="{{ old('true_answer') }}" required>
                                    <option value="answer1" {{ $question->true_answer  == 'answer1' ? 'selected' : ''}}>{{__('Answer 1')}}</option>
                                    <option value="answer2" {{ $question->true_answer  == 'answer2' ? 'selected' : ''}}>{{__('Answer 2')}}</option>
                                    <option value="answer3" {{ $question->true_answer  == 'answer3' ? 'selected' : ''}}>{{__('Answer 3')}}</option>
                                    <option value="answer4" {{ $question->true_answer  == 'answer4' ? 'selected' : ''}}>{{__('Answer 4')}}</option>
                                </select>
                                @error('true_answer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="answer_time" class="col-md-2 col-form-label">{{ __('Question Time (minutes)') }}</label>

                            <div class="col-md-10">
                                <input id="answer_time" type="number" class="form-control @error('answer_time') is-invalid @enderror" name="answer_time" value="{{ $question->answer_time }}"  autocomplete="answer_time">

                                @error('answer_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>





                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edit question') }}
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
