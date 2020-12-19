@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

            <h1>Learning Systems -  {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en}}</h1>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Learning Systems</li>
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
                <input type="text" name="search" autofocus placeholder="Search.." class="form-control" value="{{request()->search}}">
                </div>
              </div>
              <div class="col-md-6">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>Search</button>
                @if (auth()->user()->hasPermission('learning_systems-create'))
                <a href="{{route('learning_systems.create', ['lang'=> app()->getLocale() , 'country'=>$country->id]  )}}"> <button type="button" class="btn btn-primary">Create Learning System</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Create Learning System</button></a>
                @endif
                @if (auth()->user()->hasPermission('learning_systems-read'))
                <a href="{{route('learning_systems.index', ['lang'=> app()->getLocale() , 'country'=>$country->id]  )}}"> <button type="button" class="btn btn-primary">Learning Systems</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Learning Systems</button></a>
                @endif
                @if (auth()->user()->hasPermission('learning_systems-read'))
                <a href="{{route('learning_systems.trashed', ['lang'=> app()->getLocale() , 'country'=>$country->id]  )}}"> <button type="button" class="btn btn-primary">Trash</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Trash</button></a>
                @endif
              </div>
            </div>
          </form>
        </div>
      </div>


      <div class="card">
        <div class="card-header">


        <h3 class="card-title">Learning Systems</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($learning_systems->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          #id
                      </th>
                      <th>
                        image
                    </th>
                      <th>
                           Arabic Name
                      </th>
                      <th>
                        English Name
                      </th>
                      <th>
                        Country
                      </th>
                      <th>
                        Created At
                    </th>
                    <th>
                      Updated At
                  </th>
                  <?php if($learning_systems !== Null){$learning_system = $learning_systems[0];} ?>
                  @if ($learning_system->trashed())
                  <th>
                    Deleted At
                  </th>
                  @endif
                      <th style="" class="">
                        Actions
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>

                      @foreach ($learning_systems->reverse() as $learning_system)
                    <td>
                        {{ $learning_system->id }}
                    </td>
                    <td>

                      <img alt="Avatar" class="table-avatar" src="{{ asset('storage/' . $learning_system->image) }}">

                  </td>
                    <td>
                        <small>
                            {{ $learning_system->name_ar }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $learning_system->name_en }}
                      </small>
                  </td>
                  <td>
                    <h5 style="display: inline-block"><span class="badge badge-info">{{$learning_system->country->name_en}}</span></h5>
                  </td>
                    <td>
                        <small>
                            {{ $learning_system->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $learning_system->updated_at }}
                      </small>
                  </td>
                  @if ($learning_system->trashed())
                  <td>
                    <small>
                        {{ $learning_system->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-actions">

                        @if (!$learning_system->trashed())
                            @if (auth()->user()->hasPermission('stages-read'))
                                <a href="{{route('stages.index' , ['lang'=>app()->getLocale() , 'learning_system'=>$learning_system->id , 'country'=>$country->id])}}" class="btn btn-danger btn-sm">
                                    <i class="far fa-circle nav-icon"></i>
                                    {{__('stages')}}
                                </a>
                            @endif
                        @if (auth()->user()->hasPermission('learning_systems-update'))
                        <a class="btn btn-info btn-sm" href="{{route('learning_systems.edit' , ['lang'=>app()->getLocale() , 'learning_system'=>$learning_system->id , 'country'=>$country->id])}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
                        @else
                        <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                      </a>
                      @endif
                        @else
                        @if (auth()->user()->hasPermission('learning_systems-restore'))

                        <a class="btn btn-info btn-sm" href="{{route('learning_systems.restore' , ['lang'=>app()->getLocale() , 'learning_system'=>$learning_system->id , 'country'=>$country->id])}}">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Restore
                      </a>
                      @else
                      <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                        <i class="fas fa-pencil-alt">
                        </i>
                        Restore
                    </a>
                    @endif
                                @endif

                                @if ((auth()->user()->hasPermission('learning_systems-delete'))| (auth()->user()->hasPermission('learning_systems-trash')))

                                    <form method="POST" action="{{route('learning_systems.destroy' , ['lang'=>app()->getLocale() , 'learning_system'=>$learning_system->id , 'country'=>$country->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($learning_system->trashed())
                                                    {{ __('Delete') }}
                                                    @else
                                                    {{ __('Trash') }}
                                                    @endif
                                                </button>
                                    </form>
                                    @else
                                    <button  class="btn btn-danger btn-sm">
                                      <i class="fas fa-trash">
                                      </i>
                                      @if ($learning_system->trashed())
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

          <div class="row mt-3"> {{ $learning_systems->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">No Learning Systems To Show</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection
