@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Users')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('Users')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

      <div class="row">
        <div class="col-md-12">
          <form action="">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                <input type="text" name="search" autofocus placeholder="{{__('Search by phone or email or name..')}}" class="form-control" value="{{request()->search}}">
                </div>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="type" style="display:inline-block">
                  <option value="" selected>{{__('All Users')}}</option>
                  <option value="student" {{ request()->type == 'student' ? 'selected' : ''}}>{{__('student')}}</option>
                  <option value="teacher" {{ request()->type == 'teacher' ? 'selected' : ''}}>{{__('teacher')}}</option>
                  <option value="employee" {{ request()->type == 'employee' ? 'selected' : ''}}>{{__('employee')}}</option>

                </select>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="role_id" style="display:inline-block">
                  <option value="" selected>{{__('All Roles')}}</option>
                  @foreach ($roles as $role)
                  <option value="{{$role->id}}" {{ request()->role_id == $role->id ? 'selected' : ''}}>{{$role->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="country_id" style="display:inline-block">
                  <option value="" selected>{{__('All Countries')}}</option>
                  @foreach ($countries as $country)
                  <option value="{{$country->id}}" {{ request()->country_id == $country->id ? 'selected' : ''}}>{{app()->getLocale() == 'ar' ?  $country->name_ar : $country->name_en}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
                @if (auth()->user()->hasPermission('users-create'))
                <a href="{{route('users.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">{{__('Create user')}}</button></a>
                @else
                <a href="#" disabled> <button type="button" class="btn btn-primary">{{__('Create user')}}</button></a>
                @endif
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">{{__('Users')}}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($users->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          #id
                      </th>
                      <th>
                          {{__('Name')}}
                      </th>
                      <th>
                          {{__('Profile')}}
                      </th>
                      <th>
                          {{__('user Type')}}
                      </th>
                      <th>
                        {{__('user country')}}
                    </th>
                      <th>
                        {{__('user Roles')}}
                    </th>
                    <th>
                        {{__('Orders')}}
                    </th>
                      <th>
                        {{__('Created At')}}
                    </th>
                    <th>
                      {{__('Updated At')}}
                  </th>
                  <?php if($users !== Null){$user = $users[0];} ?>
                  @if ($user->trashed())
                  <th>
                    {{__('Deleted At')}}
                  </th>
                  @endif
                      <th style="" class="text-center">
                          {{__('Status')}}
                      </th>
                      <th style="" class="">
                        {{__('Actions')}}
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>

                      @foreach ($users->reverse() as $user)
                    <td>
                        {{ $user->id }}
                    </td>
                    <td>
                        <small>
                            {{ $user->name }}
                        </small>
                    </td>
                    <td>

                                <img alt="Avatar" class="table-avatar" src="{{ asset('storage/images/users/' . $user->profile) }}">

                    </td>
                    <td>

                        <small>

                            @if ($user->type == 'student')
                                {{__('student')}}
                            @elseif($user->type == 'teacher')
                                {{__('teacher')}}
                            @else
                                {{__('Employee')}}
                            @endif

                        </small>
                    </td>
                    <td>
                      <small>
                          {{app()->getLocale() == 'ar' ?  $user->country->name_ar :  $user->country->name_en}}
                      </small>
                  </td>
                    <td>
                      <small>
                          {{-- {{ implode(', ' , $user->roles->pluck('name')->toArray()) }} --}}
                          @foreach ($user->roles as $role)
                      <h5 style="display: inline-block"><span class="badge badge-primary">{{$role->name}}</span></h5>

                          @endforeach
                      </small>
                  </td>
                  <td>
                    <small>
                        @if (auth()->user()->hasPermission('orders-read'))
                        <a href="{{route('orders.create' , ['lang' => app()->getLocale() , 'user' => $user->id])}}" class="btn btn-sm btn-primary">{{__('add order')}}</a>
                        @else
                        <a href="#" class="btn btn-sm btn-primary disabled">{{__('add order')}}</a>

                        @endif
                    </small>
                    <small>
                        @if (auth()->user()->hasPermission('addresses-read'))
                        <a href="{{route('addresses.index' , ['lang' => app()->getLocale() , 'user' => $user->id])}}" class="btn btn-sm btn-primary">{{__('add address')}}</a>
                        @else
                        <a href="#" class="btn btn-sm btn-primary disabled">{{__('add address')}}</a>

                        @endif
                    </small>
                </td>
                    <td>
                        <small>
                            {{ $user->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $user->updated_at }}
                      </small>
                  </td>
                  @if ($user->trashed())
                  <td>
                    <small>
                        {{ $user->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-state">
                        @if ($user->hasVerifiedPhone())
                        <span class='badge badge-success'>{{__('Active')}}</span>
                        @else
                        <span class='badge badge-danger'>{{__('Not Active')}}</span>
                        @endif
                    </td>
                    <td class="project-actions">

                        @if (!$user->trashed())



                        @if (auth()->user()->hasPermission('homeworks_monitor-read'))

                        @if ($user->hasRole('administrator'))

                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-primary-{{$user->id}}">
                            {{__('Teachers Monitor')}}
                        </button>

                        @endif

                        @endif




                        @if (auth()->user()->hasPermission('users-read'))
                        <a class="btn btn-primary btn-sm" href="{{route('users.show' , [app()->getLocale() , $user->id])}}">
                            <i class="fas fa-folder">
                            </i>
                            {{__('View')}}
                        </a>
                        @else
                        <a class="btn btn-primary btn-sm" href="#" aria-disabled="true">
                          <i class="fas fa-folder">
                          </i>
                          {{__('View')}}
                        </a>
                        @endif
                        @if (auth()->user()->hasPermission('users-update'))
                        <a class="btn btn-info btn-sm" href="{{route('users.edit' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            {{__('Edit')}}
                        </a>
                        @else
                        <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                          <i class="fas fa-pencil-alt">
                          </i>
                          {{__('Edit')}}
                        </a>
                        @endif
                        @if (auth()->user()->hasPermission('users-update'))

                            @if ($user->hasVerifiedPhone())
                            <a class="btn btn-info btn-sm" href="{{route('users.deactivate' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}">
                                {{__('Deactivate')}}
                            </a>
                            @else
                            <a class="btn btn-info btn-sm" href="{{route('users.activate' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}">
                                {{__('Activate')}}
                            </a>
                            @endif


                        @else

                            @if ($user->hasVerifiedPhone())
                            <a class="btn btn-info btn-sm" href="#">
                                {{__('Deactivate')}}
                            </a>
                            @else
                            <a class="btn btn-info btn-sm" href="#">
                                {{__('Activate')}}
                            </a>
                            @endif

                        @endif
                        @else
                        @if (auth()->user()->hasPermission('users-restore'))
                        <a class="btn btn-info btn-sm" href="{{route('users.restore' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}">
                          <i class="fas fa-pencil-alt">
                          </i>
                          {{__('Restore')}}
                        </a>
                        @else
                        <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                          <i class="fas fa-pencil-alt">
                          </i>
                          {{__('Restore')}}
                        </a>
                        @endif
                                @endif

                                @if ((auth()->user()->hasPermission('users-delete'))| (auth()->user()->hasPermission('users-trash')))
                                    <form method="POST" action="{{route('users.destroy' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($user->trashed())
                                                    {{ __('Delete') }}
                                                    @else
                                                    {{ __('Trash') }}
                                                    @endif
                                                </button>
                                    </form>
                                    @else
                                    <button class="btn btn-danger btn-sm">
                                      <i class="fas fa-trash">
                                      </i>
                                      @if ($user->trashed())
                                      {{ __('Delete') }}
                                      @else
                                      {{ __('Trash') }}
                                      @endif
                                  </button>
                                  @endif





                    </td>
                </tr>

                      @endforeach

              </tbody>
          </table>

          <div class="row mt-3"> {{ $users->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">{{__('No Users To Show')}}</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

    @foreach ($users->reverse() as $user)

    @if (auth()->user()->hasPermission('homeworks_monitor-read'))

    @if ($user->hasRole('administrator'))



    <div class="modal fade" id="modal-primary-{{$user->id}}">
        <div class="modal-dialog">
          <div class="modal-content bg-primary">
            <div class="modal-header">
              <h4 style="direction: rtl;" class="modal-title">{{__('Add teachers to monitro for - ') . $user->name}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="{{route('users.monitor', ['lang'=> app()->getLocale() , 'user'=>$user->id ])}}" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label">{{ __('Select Country') }}</label>
                        <div class="col-md-8">
                            <select style="height: 50px;" class=" select4 form-control @error('status') is-invalid @enderror" name="countries[]" value="{{ old('status') }}" multiple="multiple">


                                @foreach ($countries as $country)
                                <option value="{{$country->id}}" {{ $user->monitor->countries()->where('country_id', $country->id)->first() != null ? 'selected' : ''}}>{{app()->getLocale() == 'ar' ?  $country->name_ar : $country->name_en}}</option>
                                @endforeach
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label">{{ __('Select Course') }}</label>
                        <div class="col-md-8">
                            <select style="height: 50px;" class=" select4 form-control @error('status') is-invalid @enderror" name="courses[]"  multiple="multiple">
                                @foreach ($courses as $course)

                                <option value="{{$course->id}}" {{ $user->monitor->courses()->where('course_id', $course->id)->first() != null ? 'selected' : ''}}>{{app()->getLocale() == 'ar' ?  $course->name_ar . ' - ' . $course->ed_class->name_ar : $course->name_en . ' - ' . $course->ed_class->name_en}}</option>
                                @endforeach
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label">{{ __('Select Teacher') }}</label>
                        <div class="col-md-8">
                            <select style="height: 50px;" class=" select4 form-control @error('status') is-invalid @enderror" name="teachers[]" multiple="multiple">
                                @foreach ($users as $suser)
                                @if ($suser->type == 'teacher')
                                <option value="{{$suser->id}}" {{ $user->monitor->teachers()->where('user_id', $suser->id)->first() != null ? 'selected' : ''}}>{{$suser->name}}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-outline-light">{{__('Save changes')}}</button>
                </div>

            </form>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    @endif

    @endif

    @endforeach


  @endsection

