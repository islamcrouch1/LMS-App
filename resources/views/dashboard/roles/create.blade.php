@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Roles</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item">Roles</li>
                <li class="breadcrumb-item active">Add New Role</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add Role') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{url(app()->getLocale() . '/dashboard/roles' )}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label">{{ __('Name') }}</label>

                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label">{{ __('Role Description') }}</label>

                            <div class="col-md-10">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}"  autocomplete="description">

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="permissions" class="col-md-2 col-form-label">{{ __('Permissions') }}</label>

                            <div class="col-md-10">
                                {{-- <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus> --}}

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Model</th>
                                            <th>Permission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $models = ['users' , 'roles' , 'settings' , 'learning_systems' , 'countries' , 'stages' , 'ed_classes' , 'courses' , 'chapters' , 'lessons']
                                        @endphp
                                        @foreach ($models as $index=>$model)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$model}}</td>
                                            <td>
                                                @php
                                                    $permissions_maps = ['create' , 'update' , 'read' , 'delete' , 'trash' , 'restore']
                                                @endphp

                                                @if ($model == 'settings')
                                                    @php
                                                        $permissions_maps = ['create' , 'update' ]

                                                    @endphp
                                                @endif
                                                <select name="permissions[]"class="form-control select4  @error('permissions') is-invalid @enderror" multiple="multiple">
                                                    @foreach ($permissions_maps as $permissions_map)
                                                    <option value="{{$model . '-' . $permissions_map}}">{{$permissions_map}}</option>   
                                                    @endforeach
                                                </select>
                                                @error('permissions')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </td>
                                        </tr> 
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add New Role') }}
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