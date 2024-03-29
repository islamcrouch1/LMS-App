@extends('layouts.dashboard.app')

@section('adminContent')




<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update user') ." ". $user->name }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('users.update' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

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
                            <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('Account Type') }}</label>

                            <div class="col-md-10">

                                <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref"  type="type" class="form-control @error('type') is-invalid @enderror" name="type"  required>
                                    @php
                                        $types = ['student','teacher','employee']
                                    @endphp
                                    @foreach ($types as $type)
                                    <option value="{{ $type }}"  {{ ($user->type == $type) ? 'selected' : ''}}>{{ $type }}</option>
                                    @endforeach
                                  </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('Permissions') }}</label>

                            <div class="col-md-10">

                                <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" id="role" type="role" class="form-control @error('role') is-invalid @enderror" name="role" value="{{ $user->role }}" required>
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}"  {{ $user->hasRole($role->name) ? 'selected' : ''}}>{{$role->name}}</option>
                                    @endforeach

                                </select>
                                @error('role')
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
                                <input id="phone" type="txt" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="email">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" style="display:none">
                            <label for="phone_hide" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                            <div class="col-md-6">
                                <input id="phone_hide" type="text" class="form-control @error('phone_hide') is-invalid @enderror" name="phone_hide" value="{{ old('phone_hide') }}" required autofocus>

                                @error('phone_hide')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row parent-phone-div">
                            <label for="parent_phone" class="col-md-2 col-form-label text-md-right">{{ __('Parent Phone') }}</label>

                            <div class="col-md-10">
                                <input id="parent_phone" type="tel" class="form-control @error('parent_phone') is-invalid @enderror" name="parent_phone" value="{{ $user->parent_phone }}" autocomplete="parent_phone">

                                @error('parent_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" style="display:none">
                            <label for="parent_phone_hide" class="col-md-4 col-form-label text-md-right">{{ __('Parent Phone') }}</label>

                            <div class="col-md-6">
                                <input id="parent_phone_hide" type="tel" class="form-control @error('parent_phone_hide') is-invalid @enderror" name="parent_phone_hide" value="{{ old('parent_phone_hide') }}" autocomplete="parent_phone_hide">

                                @error('parent_phone_hide')
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
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio1" value="male" checked>
                                    <label class="form-check-label" for="inlineRadio1">{{ __('Male') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio2" value="female">
                                    <label class="form-check-label" for="inlineRadio2">{{ __('Female') }}</label>
                                </div>
                                @else
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio1" value="male">
                                    <label class="form-check-label" for="inlineRadio1">{{ __('Male') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="inlineRadio2" value="female" checked>
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






  @endsection
