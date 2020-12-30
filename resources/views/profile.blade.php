@extends('layouts.front.app')


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

    #video_input_wrapper .fa{
        color:#000;
    }

</style>

@endpush



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('My Profile') }}</div>
        </div>


        @if ($user->type == 'teacher')


        @if ($user->teacher->status == 0)

        <div style="padding:20px" class="row">
            <div class="col-md-12 pt-2">
                <h6>{{__('Account Status')}} <span class="badge badge-warning badge-lg">{{__('Busy !')}}</span></h6>
                <p>{{__('If you are available to provide services on the site, please click the Activate Account button')}}</p>
            </div>
            <div class="col-md-12">
                <a href="{{route('profile.activate' , ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id])}}" type="button" class="btn btn-outline-primary">{{__('Activate Account')}}</a>
                <a href="{{route('teachers.display' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id , 'user'=> $user->id])}}" type="button" class="btn btn-outline-primary">{{__('Show your Profile')}}</a>


            </div>
        </div>

        @else

        <div style="padding:20px" class="row">
            <div class="col-md-12 pt-2">
                <h6>{{__('Account Status')}} <span class="badge badge-success badge-lg">{{__('Active ')}}</span></h6>
                <p>{{__('Dear teacher, if you do not have time to provide services now and want to temporarily disable your account, please click on the busy button')}}</p>
            </div>
            <div class="col-md-12">
                <a href="{{route('profile.deactivate' , ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id])}}" type="button" class="btn btn-outline-primary">{{__('Deactivate Account')}}</a>
                <a href="{{route('teachers.display' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id , 'user'=> $user->id])}}" type="button" class="btn btn-outline-primary">{{__('Show your Profile')}}</a>
            </div>
        </div>

        @endif

        <div style="padding:5px" class="row">
            <div class="col-md-12 pt-2">
                <h6>{{__('Please Select - Stages - Classess - Courses -  you want to provide the teaching service')}}</h6>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <form method="POST" action="{{route('profile.courses', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id]  )}}" enctype="multipart/form-data">
                    @csrf

                @foreach ($scountry->stages as $stage)

                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="heading{{$stage->id}}">
                                <h5 class="mb-0">
                                  <a style="cursor: pointer;" class=" btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$stage->id}}" aria-expanded="false" aria-controls="collapse{{$stage->id}}">
                                    {{ app()->getLocale() == 'ar' ? $stage->name_ar : $stage->name_en}}
                                  </a>
                                </h5>
                            </div>

                            <div id="collapse{{$stage->id}}" class="collapse show" aria-labelledby="heading{{$stage->id}}" data-parent="#accordion">
                                <div class="card-body">


                                    @foreach ($stage->ed_classes as $class)

                                    <div id="accordion1">
                                        <div class="card">
                                            <div class="" id="headingclass{{$class->id}}">
                                                <h5 class="mb-0">
                                                  <ul class="">
                                                  <a style="cursor: pointer;" class="" data-toggle="collapse" data-target="#collapseclass{{$class->id}}" aria-expanded="true" aria-controls="collapseclass{{$class->id}}">
                                                    <li class="list-group-item active">{{ app()->getLocale() == 'ar' ? $class->name_ar : $class->name_en}}</li>
                                                  </a>
                                                </h5>
                                            </div>

                                            <div id="collapseclass{{$class->id}}" class="collapse show" aria-labelledby="headingclass{{$class->id}}" data-parent="#accordion1">
                                                <div class="">

                                                        @foreach ($class->courses as $course)


                                                        <li class="list-group-item">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="courses[]" id="inlineCheckbox1{{$course->id}}" value="{{$course->id}}"
                                                                @foreach ($user->courses as $userCourse)
                                                                {{ $course->id == $userCourse->id ? 'checked' : '' }}
                                                                @endforeach
                                                                >
                                                                <label class="form-check-label" for="inlineCheckbox1{{$course->id}}">{{ app()->getLocale() == 'ar' ? $course->name_ar : $course->name_en}} {{' - '}} {{__('Price of providing homework service for this material:') }} <span class="badge badge-info badge-lg"> {{   $course->homework_price . ' ' . $course->country->currency }} </span> {{__('Your commission from this amount:') }} <span class="badge badge-success badge-lg"> {{  $course->teacher_commission . ' ' . $course->country->currency}} </span></label>
                                                            </div>
                                                        </li>

                                                        @if ($course->homework_services->count() > 0 )
                                                            <li class="list-group-item">
                                                                <h6>{{__('Addon Homework Services')}}</h6>
                                                                @foreach ($course->homework_services as $homework_service)
                                                                    <label class="form-check-label m-2" for="inlineCheckbox1">{{ app()->getLocale() == 'ar' ? $homework_service->name_ar : $homework_service->name_en}} {{' - '}} {{__('Price of providing this addon service : ') }} <span class="badge badge-info badge-lg"> {{   $homework_service->price . ' ' . $homework_service->country->currency }} </span> {{__('Your commission from this amount:') }} <span class="badge badge-success badge-lg"> {{  $homework_service->teacher_commission . ' ' . $homework_service->country->currency}} </span></label>
                                                                @endforeach
                                                            </li>
                                                        @endif








                                                        @endforeach

                                                </div>
                                            </div>
                                            </ul>

                                        </div>
                                    </div>

                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>

                @endforeach
                <div class="form-group row mb-0">
                    <div class="col-md-10 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </form>
            </div>
        </div>


        <div class="page-separator pt-3 pb-1">
            <div class="page-separator__text">{{ __('Your Account Information') }}</div>
        </div>

        <div style="padding:5px" class="row">
            <div class="col-md-12 pt-2">
                <h6>{{__('Dear teacher, please enter the identifying information carefully. Some of this information may appear to students and visitors to the site. It is also preferable to attach a brief introductory video to you. Thank you.')}}</h6>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{route('profile.info', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id]  )}}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="description_ar" class="col-md-2 col-form-label">{{ __('An introductory profile in Arabic') }}</label>

                        <div class="col-md-10">
                            <textarea id="description_ar" type="text" class="form-control ckeditor @error('description_ar') is-invalid @enderror" name="description_ar"  autocomplete="description">{{ $user->teacher->description_ar }}</textarea>

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
                            <textarea id="description_en" type="text" class="form-control ckeditor @error('description_en') is-invalid @enderror" name="description_en"  autocomplete="description">{{ $user->teacher->description_en }}</textarea>

                            @error('description_en')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="study_plan" class="col-md-2 col-form-label">{{ __('The study plan in the language you prefer') }}</label>

                        <div class="col-md-10">
                            <textarea id="study_plan" type="text" class="form-control ckeditor @error('study_plan') is-invalid @enderror" name="study_plan"  autocomplete="study_plan">{{ $user->teacher->study_plan }}</textarea>

                            @error('study_plan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-10 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>


        <div class="page-separator pt-3 pb-1">
            <div class="page-separator__text">{{ __('Upload your intro video') }}</div>
        </div>


        <div class="row">
            <div class="col-md-12">

                <div class="flex-column"
                id="video_input_wrapper"
                onclick="document.getElementById('video_input_file').click()"
                style="display:{{ $errors->any() ? 'none' : 'flex'}};"
                >
                    <i class="fa fa-camera fa-2x"></i>
                    <p>{{__('Click To Uploud Video')}}</p>
                </div>
                <input type="file" data-local="{{app()->getLocale()}}" data-urlp="{{route('profile.show', ['lang'=> app()->getLocale() , 'teacher'=>$user->teacher->id] )}}"  data-url="{{route('profile.video', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id] )}}" data-lesson-id="{{$user->teacher->id}}" id="video_input_file" name="" style="display:none;">

                <div class="card-body">
                    <form id="lesson_form"  style="display:{{ $errors->any() ? 'block' : 'none'}};">
                        @csrf


                        <div class="form-group row" style="display:{{ $errors->any() ? 'none' : ''}};">
                            <div class="col-md-4">
                                <label id="lesson-status" class="col-form-label">{{ __('Uplouding Video') }}</label>
                            </div>

                            <div class="col-md-8">
                                <div class="progress  mt-2" >
                                    <div id="video_progress" class="progress-bar" role="progressbar"></div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>




                <div  class="container page__container" id="video_div" style="{{ $user->teacher->path == NULL ? 'display:none' : 'display:block'}}; padding-bottom:20px">



                    <div id="player"></div>



                    @push('scripts-front')

                        <script>
                            var file =
                            "[Auto]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '.m3u8') }}," +
                                "[360]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '_0_100.m3u8') }}," +
                                "[480]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '_1_250.m3u8') }}," +
                                "[720]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '_2_500.m3u8') }}";

                            var player = new Playerjs({
                                id: "player",
                                file: file,
                                poster: "{{ $user->teacher->image == NULL ? '' : asset('storage/images/teachers/' . $user->teacher->image) }}",
                                default_quality: "Auto",
                            });


                        </script>

                    @endpush



                </div>
            </div>
        </div>



        <div class="page-separator pt-3 pb-1">
            <div class="page-separator__text">{{ __('Upload video cover') }}</div>
        </div>


        <div class="row">
            <div class="col-md-12" style="padding-bottom: 20px;">

                <form method="POST" action="{{route('profile.image', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id]  )}}" enctype="multipart/form-data">
                    @csrf


                    <div class="form-group row">
                        <label for="image" class="col-md-2 col-form-label">{{ __('Upload Image') }}</label>

                        <div class="col-md-10">
                            <input id="image" type="file" class="form-control-file img @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">

                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col-md-10">
                            <img src="{{ $user->teacher->image == NULL ? '' : asset('storage/images/teachers/' . $user->teacher->image) }}" style="width:350px"  class="img-thumbnail img-prev">
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                        <div class="col-md-10 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>


        <div class="page-separator pt-3 pb-1">
            <div class="page-separator__text">{{ __('your personal information') }}</div>
        </div>

        <div class="container pt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Edit your personal information') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{route('profile.update', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id]  )}}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-10">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" >

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-10">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="country" class="col-md-2 col-form-label">{{ __('Country select') }}</label>
                                    <div class="col-md-10">
                                        <select class=" form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}" required autocomplete="country" disabled>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{$user->country->id == $country->id ? 'selected' : ''}} >{{ $country->name_en }}</option>
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
                                    <label for="phone" class="col-md-2 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                                    <div class="col-md-10">
                                        <input disabled id="phone" type="txt" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="email">

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-10">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password" >

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-2 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-10">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password" ">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="gender" class="col-md-2 col-form-label text-md-right">{{ __('Gender Select') }}</label>

                                    <div class="col-md-10">
                                        @if ($user->gender == "male")
                                        <div class="form-check form-check-inline">
                                            <input disabled class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio1" value="male" checked>
                                            <label class="form-check-label" for="inlineRadio1">{{ __('Male') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input disabled class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio2" value="female">
                                            <label class="form-check-label" for="inlineRadio2">{{ __('Female') }}</label>
                                        </div>
                                        @else
                                        <div class="form-check form-check-inline">
                                            <input disabled class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio1" value="male">
                                            <label class="form-check-label" for="inlineRadio1">{{ __('Male') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input disabled class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio2" value="female" checked>
                                            <label class="form-check-label" for="inlineRadio2">{{ __('Female') }}</label>
                                        </div>
                                        @endif

                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="profile" class="col-md-2 col-form-label text-md-right">{{ __('Profile Picture') }}</label>
                                    <div class="col-md-10">
                                        <input id="profile" type="file" class="form-control-file img @error('profile') is-invalid @enderror" name="profile" value="{{ old('profile') }}">

                                        @error('profile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">

                                    <div class="col-md-10">
                                        <img src="{{ asset('storage/images/users/' . $user->profile) }}" style="width:100px"  class="img-thumbnail img-prev">
                                    </div>
                                </div>



                                <div class="form-group row mb-0">
                                    <div class="col-md-10 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @elseif ($user->type == 'student')



        <div class="container pt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Edit your personal information') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{route('profile.update', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id]  )}}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-10">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-10">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="country" class="col-md-2 col-form-label">{{ __('Country select') }}</label>
                                    <div class="col-md-10">
                                        <select class=" form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}" required autocomplete="country" disabled>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{$user->country->id == $country->id ? 'selected' : ''}} >{{ $country->name_en }}</option>
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
                                    <label for="phone" class="col-md-2 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                                    <div class="col-md-10">
                                        <input disabled id="phone" type="txt" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="email">

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row parent-phone-div">
                                    <label for="parent_phone" class="col-md-2 col-form-label text-md-right">{{ __('Parent Phone') }}</label>

                                    <div class="col-md-10">
                                        <input disabled id="parent_phone" type="tel" class="form-control @error('parent_phone') is-invalid @enderror" name="parent_phone" value="{{ $user->parent_phone }}" autocomplete="parent_phone">

                                        @error('parent_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-10">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password" >

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-2 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-10">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password" ">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="gender" class="col-md-2 col-form-label text-md-right">{{ __('Gender Select') }}</label>

                                    <div class="col-md-10">
                                        @if ($user->gender == "male")
                                        <div class="form-check form-check-inline">
                                            <input disabled class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio1" value="male" checked>
                                            <label class="form-check-label" for="inlineRadio1">{{ __('Male') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input disabled class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio2" value="female">
                                            <label class="form-check-label" for="inlineRadio2">{{ __('Female') }}</label>
                                        </div>
                                        @else
                                        <div class="form-check form-check-inline">
                                            <input disabled class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio1" value="male">
                                            <label class="form-check-label" for="inlineRadio1">{{ __('Male') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input disabled class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio2" value="female" checked>
                                            <label class="form-check-label" for="inlineRadio2">{{ __('Female') }}</label>
                                        </div>
                                        @endif

                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="profile" class="col-md-2 col-form-label text-md-right">{{ __('Profile Picture') }}</label>
                                    <div class="col-md-10">
                                        <input id="profile" type="file" class="form-control-file img @error('profile') is-invalid @enderror" name="profile" value="{{ old('profile') }}">

                                        @error('profile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">

                                    <div class="col-md-10">
                                        <img src="{{ asset('storage/images/users/' . $user->profile) }}" style="width:100px"  class="img-thumbnail img-prev">
                                    </div>
                                </div>



                                <div class="form-group row mb-0">
                                    <div class="col-md-10 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        @endif



    </div>
</div>



@endsection



