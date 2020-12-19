@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>chapters - {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en}} - {{ app()->getLocale() == 'ar' ? $course->name_ar : $course->name_en}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">chapters</li>
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
                @if (auth()->user()->hasPermission('chapters-create'))
                <a href="{{route('chapters.create', ['lang'=> app()->getLocale() , 'country'=>$country->id , 'course' => $course->id] )}}"> <button type="button" class="btn btn-primary">Create chapter</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Create chapter</button></a>
                @endif
                @if (auth()->user()->hasPermission('chapters-read'))
                <a href="{{route('chapters.index' , ['lang'=>app()->getLocale() , 'course'=>$course->id , 'country'=>$country->id])}}"> <button type="button" class="btn btn-primary">chapters</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">chapters</button></a>
                @endif
                @if (auth()->user()->hasPermission('chapters-read'))
                <a href="{{route('chapters.trashed', ['lang'=> app()->getLocale() , 'country'=>$country->id , 'course' => $course->id]  )}}"> <button type="button" class="btn btn-primary">Trash</button></a>
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


        <h3 class="card-title">chapters</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($chapters->count() > 0)
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
                        Learning System
                      </th>
                      <th>
                        Created At
                    </th>
                    <th>
                      Updated At
                  </th>
                  <?php if($chapters !== Null){$chapter = $chapters[0];} ?>
                  @if ($chapter->trashed())
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

                      @foreach ($chapters->reverse() as $chapter)
                    <td>
                        {{ $chapter->id }}
                    </td>
                    <td>
                        <small>
                            {{ $chapter->name_ar }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $chapter->name_en }}
                      </small>
                  </td>
                  <td>


                    <h5 style="display: inline-block"><span class="badge badge-info">{{$chapter->course->name_en}}</span></h5>



                  </td>
                    <td>
                        <small>
                            {{ $chapter->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $chapter->updated_at }}
                      </small>
                  </td>
                  @if ($chapter->trashed())
                  <td>
                    <small>
                        {{ $chapter->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-actions">

                        @if (!$chapter->trashed())
                            @if (auth()->user()->hasPermission('lessons-read'))
                                <a href="{{route('lessons.index' , ['lang'=>app()->getLocale() , 'chapter'=>$chapter->id , 'country'=>$country->id])}}" class="btn btn-danger btn-sm">
                                    <i class="far fa-circle nav-icon"></i>
                                    {{__('lessons')}}
                                </a>
                            @endif
                        @if (auth()->user()->hasPermission('chapters-update'))
                        <a class="btn btn-info btn-sm" href="{{route('chapters.edit' , ['lang'=>app()->getLocale() , 'chapter'=>$chapter->id , 'course'=>$course->id , 'country'=>$country->id])}}">
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
                        @if (auth()->user()->hasPermission('chapters-restore'))

                        <a class="btn btn-info btn-sm" href="{{route('chapters.restore' , ['lang'=>app()->getLocale() , 'chapter'=>$chapter->id , 'course'=>$course->id , 'country'=>$country->id])}}">
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

                                @if ((auth()->user()->hasPermission('chapters-delete'))| (auth()->user()->hasPermission('chapters-trash')))

                                    <form method="POST" action="{{route('chapters.destroy' , ['lang'=>app()->getLocale() , 'chapter'=>$chapter->id , 'course'=>$course->id , 'country'=>$country->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($chapter->trashed())
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
                                      @if ($chapter->trashed())
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

          <div class="row mt-3"> {{ $chapters->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">No chapters To Show</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection
