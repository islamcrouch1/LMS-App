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
                <select class="form-control"  name="country_id" style="display:inline-block">
                  <option value="" selected>{{__('All Countries')}}</option>
                  @foreach ($countries as $country)
                  <option value="{{$country->id}}" {{ request()->country_id == $country->id ? 'selected' : ''}}>{{app()->getLocale() == 'ar' ?  $country->name_ar : $country->name_en}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
                @if (auth()->user()->hasPermission('teachers-create'))
                <a href="{{route('teachers.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">{{__('Create user')}}</button></a>
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


        <h3 class="card-title">{{__('Teachers')}}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($users->where('type' , 'teacher')->count() > 0)
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

                      @foreach ($users as $user)

                      @if($user->type == 'teacher')

                      @if (auth()->user()->hasRole('superadministrator') || auth()->user()->monitor->countries()->where('country_id', $user->country_id)->first() != null || auth()->user()->monitor->teachers()->where('user_id', $user->user_id)->first() != null)


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

                        <button type="button" class="btn btn-default btn-sm" id="teacher_show-{{$user->id}}" data-id="{{$user->id}}" data-toggle="modal" data-target="#modal-lg-{{$user->id}}">
                            {{__('Teacher Data')}}
                        </button>




                        @if (auth()->user()->hasPermission('teachers-read'))
                        <a class="btn btn-primary btn-sm" href="{{route('teachers.show' , [app()->getLocale() , $user->id])}}">
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
                        @if (auth()->user()->hasPermission('teachers-update'))
                        <a class="btn btn-info btn-sm" href="{{route('teachers.edit' , ['lang'=>app()->getLocale() , 'teacher'=>$user->id])}}">
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
                        @if (auth()->user()->hasPermission('teachers-update'))

                            @if ($user->hasVerifiedPhone())
                            <a class="btn btn-info btn-sm" href="{{route('teachers.deactivate' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}">
                                {{__('Deactivate')}}
                            </a>
                            @else
                            <a class="btn btn-info btn-sm" href="{{route('teachers.activate' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}">
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
                        @if (auth()->user()->hasPermission('teachers-restore'))
                        <a class="btn btn-info btn-sm" href="{{route('teachers.restore' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}">
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







                    </td>
                </tr>
                @endif
                @endif
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


    @foreach ($users as $user)

    @if($user->type == 'teacher')


    <div class="modal fade" id="modal-lg-{{$user->id}}">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 style="direction: rtl;" class="modal-title">{{__('Teacher Informations For - ')  .$user->name}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @if ($user->teacher->status == 0)
                                <h6>{{__('Account Status')}} <span class="badge badge-warning badge-lg">{{__('Busy !')}}</span></h6>
                                @else
                                <h6>{{__('Account Status')}} <span class="badge badge-success badge-lg">{{__('Active ')}}</span></h6>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{ __('Courses and materials that the teacher provides services') }}
                            </div>
                            <div class="card-body">

                                <ul class="list-group">
                                    @if ($user->courses->count() > 0)
                                        @foreach ($user->courses as $course)

                                        <li dir="rtl" class="list-group-item p-2">
                                            <label class="form-check-label" for="inlineCheckbox1">{{ app()->getLocale() == 'ar' ? $course->name_ar : $course->name_en}} {{' - '}} {{__('Price of providing homework service for this material:') }} <span class="badge badge-info badge-lg"> {{   $course->homework_price . ' ' . $course->country->currency }} </span> {{__('Teacher commission from this amount:') }} <span class="badge badge-success badge-lg"> {{  $course->teacher_commission . ' ' . $course->country->currency}} </span></label>
                                        </li>

                                        @endforeach

                                    @else

                                    {{ __('The teacher did not choose any course to offer its services') }}

                                    @endif

                                </ul>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{ __('An introductory profile of the teacher in Arabic') }}
                            </div>
                            <div class="card-body">
                                <h6>{!! $user->teacher->description_ar !!}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{ __('An introductory profile of the teacher in English') }}
                            </div>
                            <div class="card-body">
                                <h6>{!! $user->teacher->description_en !!}</h6>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{ __('The teacher\'s study plan') }}
                            </div>
                            <div class="card-body">
                                <h6>{!! $user->teacher->study_plan !!}</h6>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{ __('Introductory video for the teacher') }}
                            </div>
                            <div class="card-body">

                                <div id="player-{{$user->id}}"></div>



                                @push('scripts')

                                <script>

                                    var userid = "{{$user->id}}";

                                    var button_show = '#teacher_show-' + userid;


                                    console.log(button_show);


                                  $(button_show).on('click',  function(e) {

                                  e.preventDefault();

                                  var id = $(this).data('id');

                                  var modal = '#modal-lg-' + id ;

                                  var players = 'player-' + id ;

                                  $(modal).show('show', function() {

                                      console.log(modal);


                                            var file =
                                    "[Auto]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '.m3u8') }}," +
                                        "[360]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '_0_100.m3u8') }}," +
                                        "[480]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '_1_250.m3u8') }}," +
                                        "[720]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '_2_500.m3u8') }}";

                                    var player = new Playerjs({
                                        id: players,
                                        file: file,
                                        poster: "{{ $user->teacher->image == NULL ? '' : asset('storage/images/teachers/' . $user->teacher->image) }}",
                                        default_quality: "Auto",
                                    });


                                      });

                                  });






                                </script>

                              @endpush



                            </div>
                        </div>
                    </div>
                </div>




            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{__('Close')}}</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    @endif
    @endforeach


  @endsection




