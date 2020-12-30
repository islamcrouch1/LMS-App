@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Reports')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('Reports')}}</li>
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
                <input type="text" name="search" autofocus placeholder="{{__('Search By Student Name ..')}}" class="form-control" value="{{request()->search}}">
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
                {{-- @if (auth()->report()->hasPermission('reports-create'))
                <a href="{{route('reports.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">{{__('Create report')}}</button></a>
                @else
                <a href="#" disabled> <button type="button" class="btn btn-primary">{{__('Create report')}}</button></a>
                @endif --}}
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">{{__('Reports')}}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($reports->count() > 0)
          <table class="table table-striped projects">
              <thead>

                  <tr>

                    <th class="text-center">#id</th>
                    <th class="text-center">{{__('Profile')}}</th>
                    <th class="text-center">{{__('Name')}}</th>
                    <th class="text-center">{{__('Servise')}}</th>
                    <th class="text-center">{{__('Request Date')}}</th>
                    <th class="text-center">{{__('Actions')}}</th>

                  </tr>

              </thead>

              <tbody>

                  <tr>

                    @foreach ($reports->reverse() as $report)
                    <td  class="text-center">{{ $report->id }}</td>
                    <td  class="text-center"><img alt="Avatar" class="table-avatar" src="{{ asset('storage/images/users/' . $report->user->profile) }}"></td>
                    <td  class="text-center"><small><a href="{{route('users.show' , [app()->getLocale() , $report->user->id])}}">
                        {{ $report->user->name }}
                    </a></small></td>
                    <td  class="text-center">
                        @switch($report->service)
                        @case('homework')
                        <span class="badge badge-success badge-lg">{{__('Request Homework service')}}</span>
                            @break
                        @case('library')
                        <span class="badge badge-info badge-lg">{{__('Library Order')}}</span>
                            @break
                        @case('course')
                        <span class="badge badge-primary badge-lg">{{__('Buying educational courses')}}</span>
                            @break
                        @endswitch


                    </td>
                    <td  class="text-center"><small>{{ $report->created_at }}</small></td>
                    <td class="project-actions">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg-{{$report->id}}">
                            {{__('Request Details')}}
                        </button>
                    </td>



                </tr>
                      @endforeach


              </tbody>
          </table>

          <div class="row mt-3"> {{ $reports->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">{{__('No Reports To Show')}}</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->




    @foreach ($reports->reverse() as $report)


    <div class="modal fade" id="modal-lg-{{$report->id}}">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 style="direction: rtl;" class="modal-title">{{__('Request Details For - ') . $report->user->name}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <ul class="list-group">
                  <li dir="rtl" class="list-group-item p-2">{{__('Report Details')}}{!!$report->details!!}</li>

                  @if ($report->report_image != '#' )
                  <li dir="rtl" class="list-group-item p-2"><img src="{{asset('storage/images/reports/' . $report->report_image)}}" ></li>
                  @endif


                  @if($report->report_file != '#' )
                  <li dir="rtl" class="list-group-item p-2">

                    <div class="form-group row down_link p-2">

                        <div class="col-md-10">
                            <a class="btn-info" style="padding: 10px; border-radius: 5px;" href="{{ asset('storage/reports/files/' . $report->report_file) }}">{{__('Download File')}}</a>
                        </div>
                    </div>

                  </li>
                  @endif


              </ul>
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

