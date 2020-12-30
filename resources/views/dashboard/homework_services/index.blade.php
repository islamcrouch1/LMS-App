@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

            <h1>{{__('Homework Services')}}</h1>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('Homework Services')}}</li>
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
              <div class="col-md-4">
                <div class="form-group">
                <input type="text" name="search" autofocus placeholder="{{__('Search..')}}" class="form-control" value="{{request()->search}}">
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
              <div class="col-md-6">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
                @if (auth()->user()->hasPermission('homework_services-create'))
                <a href="{{route('homework_services.create', ['lang'=> app()->getLocale()]  )}}"> <button type="button" class="btn btn-primary">{{__('Create Homework Servise')}}</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">{{__('Create Homework Servise')}}</button></a>
                @endif
                @if (auth()->user()->hasPermission('homework_services-read'))
                <a href="{{route('homework_services.trashed', ['lang'=> app()->getLocale()])}}"> <button type="button" class="btn btn-primary">{{__('Services Trash')}}</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">{{__('Services Trash')}}</button></a>
                @endif
              </div>
            </div>
          </form>
        </div>
      </div>


      <div class="card">
        <div class="card-header">


        <h3 class="card-title">{{__('Homework Services')}}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($homework_services->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>

                        <th>#id</th>
                        <th>{{__('Arabic Name')}}</th>
                        <th>{{__('English Name')}}</th>
                        <th>{{__('Price')}}</th>
                        <th>{{__('Teacher Commission')}}</th>
                        <th>{{__('Country')}}</th>
                        <th>{{__('Created At')}}</th>
                        <th>{{__('Updated At')}}</th>

                        <?php if($homework_services !== Null){$homework_service = $homework_services[0];} ?>

                        @if ($homework_service->trashed())
                        <th>{{__('Deleted At')}}</th>
                        @endif
                        <th style="" class="">{{__('Actions')}}</th>

                  </tr>
              </thead>

              <tbody>
                <tr>

                    @foreach ($homework_services->reverse() as $homework_service)

                    <td>{{ $homework_service->id }}</td>
                    <td><small>{{ $homework_service->name_ar }}</small></td>
                    <td><small>{{ $homework_service->name_en }}</small></td>
                    <td><small>{{ $homework_service->price . ' ' . $homework_service->country->currency }}</small></td>
                    <td><small>{{ $homework_service->teacher_commission . ' ' . $homework_service->country->currency }}</small></td>
                    <td><h5 style="display: inline-block"><span class="badge badge-info">{{$homework_service->country->name_en}}</span></h5></td>
                    <td><small>{{ $homework_service->created_at }}</small></td>
                    <td><small>{{ $homework_service->updated_at }}</small></td>

                    @if ($homework_service->trashed())
                    <td><small>{{ $homework_service->deleted_at }}</small></td>
                    @endif


                    <td class="project-actions">

                        @if (!$homework_service->trashed())

                            @if (auth()->user()->hasPermission('homework_services-update'))
                            <a class="btn btn-info btn-sm" href="{{route('homework_services.edit' , ['lang'=>app()->getLocale() , 'homework_service'=>$homework_service->id])}}">
                                <i class="fas fa-pencil-alt"></i>{{__('Edit')}}
                            </a>
                            @else
                            <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                            <i class="fas fa-pencil-alt"></i>{{__('Edit')}}
                            </a>
                            @endif

                        @else

                            @if (auth()->user()->hasPermission('homework_services-restore'))

                            <a class="btn btn-info btn-sm" href="{{route('homework_services.restore' , ['lang'=>app()->getLocale() , 'homework_service'=>$homework_service->id])}}">
                                <i class="fas fa-pencil-alt"></i>{{__('Restore')}}
                            </a>
                            @else
                            <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                                <i class="fas fa-pencil-alt"></i>{{__('Restore')}}
                            </a>
                            @endif

                        @endif

                        @if ((auth()->user()->hasPermission('homework_services-delete'))| (auth()->user()->hasPermission('homework_services-trash')))

                            <form method="POST" action="{{route('homework_services.destroy' , ['lang'=>app()->getLocale() , 'homework_service'=>$homework_service->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete">
                                        <i class="fas fa-trash"></i>
                                        @if ($homework_service->trashed())
                                            {{ __('Delete') }}
                                        @else
                                            {{ __('Trash') }}
                                        @endif
                                    </button>
                            </form>

                        @else

                            <button  class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                                @if ($homework_service->trashed())
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

          <div class="row mt-3"> {{ $homework_services->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">{{__('NO Homework Services To Show')}}</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection
