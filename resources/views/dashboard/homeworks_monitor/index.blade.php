@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Monitoring homework')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('Monitoring homework')}}</li>
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
                <input type="text" name="search" autofocus placeholder="{{__('Search By Teacher Name Or Student Name ..')}}" class="form-control" value="{{request()->search}}">
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
              <div class="col-md-2">
                <select class="form-control"  name="course_id" style="display:inline-block">
                  <option value="" selected>{{__('All courses')}}</option>
                  @foreach ($courses as $course)
                  <option value="{{$course->id}}" {{ request()->course_id == $country->id ? 'selected' : ''}}>{{ app()->getLocale() == 'ar' ? $course->name_ar . ' - ' . $course->ed_class->name_ar  : $course->name_en  . ' - ' . $course->ed_class->name_en }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                @php
                $order_status = ['recieved' , 'waiting' , 'solution' , 'done']
                @endphp
                <select class="form-control"  name="status" style="display:inline-block">
                  <option value="" selected>{{__('All Status')}}</option>
                  @foreach ($order_status as $order_status)

                  @switch($order_status)
                      @case('recieved')
                      <option value="{{$order_status}}" {{ ($order_status == request()->status) ? 'selected' : '' }}>{{__('Received')}}</option>
                          @break
                      @case("waiting")
                      <option value="{{$order_status}}" {{ ($order_status == request()->status) ? 'selected' : '' }}>{{__('Waiting for the receipt')}}</option>
                      @break
                      @case("solution")
                      <option value="{{$order_status}}" {{ ($order_status == request()->status) ? 'selected' : '' }}>{{__('The solution is ready')}}</option>
                      @break
                      @case("done")
                      <option value="{{$order_status}}" {{ ($order_status == request()->status) ? 'selected' : '' }}>{{__('A completed request')}}</option>
                      @break
                      @default
                  @endswitch
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
                {{-- @if (auth()->request()->hasPermission('requestals-create'))
                <a href="{{route('requestals.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">{{__('Create request')}}</button></a>
                @else
                <a href="#" disabled> <button type="button" class="btn btn-primary">{{__('Create request')}}</button></a>
                @endif --}}
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">{{__('Monitoring homework')}}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($requests->count() > 0)
          <table class="table table-striped projects">
              <thead>

                  <tr>

                    <th class="text-center">#id</th>
                    <th class="text-center">{{__('Profile')}}</th>
                    <th class="text-center">{{__('Teacher Name')}}</th>
                    <th class="text-center">{{__('Student Name')}}</th>
                    <th class="text-center">{{__('Course')}}</th>
                    <th class="text-center">{{__('Request Title')}}</th>
                    <th class="text-center">{{__('Status')}}</th>
                    <th class="text-center">{{__('Created At')}}</th>
                    <th class="text-center">{{__('Updated At')}}</th>
                    <th class="text-center">{{__('Actions')}}</th>

                  </tr>

              </thead>

              <tbody>

                  <tr>

                    @foreach ($requests->reverse() as $request)
                        @php
                        $teacher = App\User::find($request->teacher_id);
                        @endphp

                    @if (auth()->user()->hasRole('superadministrator') || auth()->user()->monitor->countries()->where('country_id', $request->country_id)->first() != null || auth()->user()->monitor->courses()->where('course_id', $request->course_id)->first() != null || auth()->user()->monitor->teachers()->where('user_id', $request->teacher_id)->first() != null)


                    <td  class="text-center">{{ $request->id }}</td>
                    <td  class="text-center"><img alt="Avatar" class="table-avatar" src="{{ asset('storage/images/users/' . $teacher->profile) }}"></td>
                    <td  class="text-center"><small><a href="{{route('users.show' , [app()->getLocale() , $teacher->id])}}">
                        {{ $teacher->name }}
                    </a></small></td>
                    <td  class="text-center"><small><a href="{{route('users.show' , [app()->getLocale() , $request->user->id])}}">
                        {{ $request->user->name }}
                    </a></small></td>
                    <td  class="text-center"><small>{{ app()->getLocale() == 'ar' ? $request->course->name_ar . ' - ' . $request->course->ed_class->name_ar  : $request->course->name_en  . ' - ' . $request->course->ed_class->name_en }}</small></td>
                    <td  class="text-center"><small>{{ $request->homework_title }}</small></td>
                    <td class="project-state">
                        @switch($request->status)
                        @case('waiting')
                        <span class="badge badge-info badge-lg">{{__('Waiting to receive the request from the teacher')}}</span>
                            @break
                        @case('done')
                        <span class="badge badge-info badge-lg">{{__('Completed Request')}}</span>
                            @break
                        @case('recieved')
                        <span class="badge badge-info badge-lg">{{__('Request Recieved')}}</span>
                            @break
                        @case('solution')
                        <span class="badge badge-info badge-lg">{{__('The solution is ready')}}</span>
                            @break
                        @default
                        @endswitch
                    </td>
                    <td  class="text-center"><small>{{ $request->created_at }}</small></td>
                    <td  class="text-center"><small>{{ $request->updated_at }}</small></td>
                    <td class="project-actions">

                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg-{{$request->id}}">
                            {{__('Request Details')}}
                        </button>


                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-mg-{{$request->id}}">
                            {{__('Comments')}}
                        </button>

                    </td>

                </tr>

                @endif
                      @endforeach


              </tbody>
          </table>

          <div class="row mt-3"> {{ $requests->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">{{__('No requests To Show')}}</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


    @foreach ($requests->reverse() as $request)


    <div class="modal fade" id="modal-lg-{{$request->id}}">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 style="direction: rtl;" class="modal-title">{{$request->homework_title}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{ __('Data sent by the teacher') }}
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $request->homework_title}}</h5>
                                <p class="card-text">{!! $request->teacher_note !!}</p>
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        @if ($request->teacher_image != '#')
                                        <img src="{{ asset('storage/images/homework/' . $request->teacher_image) }}" style="width:350px"  class="img-thumbnail img-prev">
                                        @endif
                                    </div>
                                </div>
                              <a href="{{ $request->teacher_file == '#' ? '#' : asset('storage/homework/files/' . $request->teacher_file) }}" class="btn btn-primary">{{ $request->teacher_file == '#' ? __('No file attached') : __('Download File') }}</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{ __('Data sent by the student') }}
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $request->homework_title}}</h5>
                                <p class="card-text">{!! $request->student_note !!}</p>
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        @if ($request->student_image != '#')
                                        <img src="{{ asset('storage/images/homework/' . $request->student_image) }}" style="width:350px"  class="img-thumbnail img-prev">
                                        @endif
                                    </div>
                                </div>
                              <a href="{{ $request->student_file == '#' ? '#' : asset('storage/homework/files/' . $request->student_file) }}" class="btn btn-primary">{{ $request->student_file == '#' ? __('No file attached') : __('Download File') }}</a>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{ __('Request Status')  }}
                                    @switch($request->status)
                                    @case('waiting')
                                    <span class="badge badge-info badge-lg">{{__('Waiting to receive the request from the teacher')}}</span>
                                        @break
                                    @case('done')
                                    <span class="badge badge-info badge-lg">{{__('Completed Request')}}</span>
                                        @break
                                    @case('recieved')
                                    <span class="badge badge-info badge-lg">{{__('Request Recieved')}}</span>
                                        @break
                                    @case('solution')
                                    <span class="badge badge-info badge-lg">{{__('The solution is ready')}}</span>
                                        @break
                                    @default
                                    @endswitch
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="card-title">{{ __('The date of receiving the application') .' : ' . $request->recieve_time}}</h5>
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



    <div class="modal fade" id="modal-mg-{{$request->id}}">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 style="direction: rtl;" class="modal-title">{{$request->homework_title}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">



                <div class="row">
                    <div class="col-md-12">
                        <div id="comments">

                            @foreach ($request->home_work_comments->reverse() as $homeworkComment)
                            <div class="pt-3 mb-24pt">
                                <div class="d-flex mb-3">
                                    <a href=""
                                        style=" {{app()->getLocale() == 'ar' ? 'margin-left: 10px;' : ''}} "
                                       class="avatar avatar-sm mr-12pt">
                                        <img style="width:30px" src="{{ asset('storage/images/users/' . $homeworkComment->user->profile) }}" alt="people" class="avatar-img rounded-circle m-2">
                                    </a>
                                    <div class="flex">
                                        <a href=""
                                           class="text-body"><strong> {{$homeworkComment->user->name}} </strong> <small class="text-50 mr-2"> {{' ( ' . $homeworkComment->created_at . ' ) '}} </small></a> <br>
                                        <p class="mt-1 text-70"> {{$homeworkComment->message}} </p>

                                        @if($homeworkComment->comment_file != '#' )


                                        <div class="form-group row down_link pt-1">
                                            <div class="col-md-12">
                                                <a class="btn-info" style="padding: 10px; border-radius: 5px;" href="{{ asset('storage/comments/files/' . $homeworkComment->comment_file) }}">{{__('Download File')}}</a>
                                            </div>
                                        </div>

                                        @endif

                                        @if ($homeworkComment->comment_image != '#')
                                        <img src="{{ asset('storage/images/comments/' . $homeworkComment->comment_image) }}" style="width:350px"  class="img-thumbnail img-prev">
                                        @endif

                                        <div class="d-flex align-items-center">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

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



      @endforeach


  @endsection

