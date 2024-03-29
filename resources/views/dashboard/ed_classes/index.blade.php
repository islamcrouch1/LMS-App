@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Classes - {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en}} - {{ app()->getLocale() == 'ar' ? $stage->name_ar : $stage->name_en}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Classes</li>
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
              <div class="col-md-4">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>Search</button>
                @if (auth()->user()->hasPermission('ed_classes-create'))
                <a href="{{route('ed_classes.create', ['lang'=> app()->getLocale() , 'country'=>$country->id , 'stage' => $stage->id] )}}"> <button type="button" class="btn btn-primary">Create Class</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Create Class</button></a>
                @endif
                @if (auth()->user()->hasPermission('ed_classes-read'))
                <a href="{{route('ed_classes.index' , ['lang'=>app()->getLocale() , 'stage'=>$stage->id , 'country'=>$country->id])}}"> <button type="button" class="btn btn-primary">Classes</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Classes</button></a>
                @endif
                @if (auth()->user()->hasPermission('ed_classes-read'))
                <a href="{{route('ed_classes.trashed', ['lang'=> app()->getLocale() , 'country'=>$country->id , 'stage' => $stage->id]  )}}"> <button type="button" class="btn btn-primary">Trash</button></a>
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


        <h3 class="card-title">Classes</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($ed_classes->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          #id
                      </th>
                      <th>
                           Arabic Name
                      </th>
                      <th>
                        English Name
                      </th>
                      <th>
                        Stage
                      </th>
                      <th>
                        Created At
                    </th>
                    <th>
                      Updated At
                  </th>
                  <?php if($ed_classes !== Null){$ed_class = $ed_classes[0];} ?>
                  @if ($ed_class->trashed())
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

                      @foreach ($ed_classes->reverse() as $ed_class)
                    <td>
                        {{ $ed_class->id }}
                    </td>
                    <td>
                        <small>
                            {{ $ed_class->name_ar }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $ed_class->name_en }}
                      </small>
                  </td>
                  <td>


                    <h5 style="display: inline-block"><span class="badge badge-info">{{$ed_class->stage->name_en}}</span></h5>



                  </td>
                    <td>
                        <small>
                            {{ $ed_class->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $ed_class->updated_at }}
                      </small>
                  </td>
                  @if ($ed_class->trashed())
                  <td>
                    <small>
                        {{ $ed_class->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-actions">

                        @if (!$ed_class->trashed())
                            @if (auth()->user()->hasPermission('courses-read'))
                                <a href="{{route('courses.index' , ['lang'=>app()->getLocale() , 'ed_class'=>$ed_class->id , 'country'=>$country->id])}}" class="btn btn-danger btn-sm">
                                    <i class="far fa-circle nav-icon"></i>
                                    {{__('Courses')}}
                                </a>
                            @endif
                        @if (auth()->user()->hasPermission('ed_classes-update'))
                        <a class="btn btn-info btn-sm" href="{{route('ed_classes.edit' , ['lang'=> app()->getLocale() , 'country'=>$country->id , 'stage' => $stage->id , 'ed_class'=>$ed_class->id])}}">
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
                        @if (auth()->user()->hasPermission('ed_classes-restore'))

                        <a class="btn btn-info btn-sm" href="{{route('ed_classes.restore' , ['lang'=> app()->getLocale() , 'country'=>$country->id , 'stage' => $stage->id , 'ed_class'=>$ed_class->id])}}">
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

                                @if ((auth()->user()->hasPermission('ed_classes-delete'))| (auth()->user()->hasPermission('ed_classes-trash')))

                                    <form method="POST" action="{{route('ed_classes.destroy' , ['lang'=> app()->getLocale() , 'country'=>$country->id , 'stage' => $stage->id , 'ed_class'=>$ed_class->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($ed_class->trashed())
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
                                      @if ($ed_class->trashed())
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

          <div class="row mt-3"> {{ $ed_classes->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">No Classes To Show</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection
