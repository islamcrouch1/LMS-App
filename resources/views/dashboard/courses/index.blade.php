@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Courses</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Courses</li>
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
                @if (auth()->user()->hasPermission('courses-create'))
                <a href="{{route('courses.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">Create Course</button></a>

                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Create Course</button></a>

                @endif
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">

           
        <h3 class="card-title">Courses</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($courses->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          #id
                      </th>
                      <th>
                        Image
                    </th>
                      <th>
                           Arabic Name
                      </th>
                      <th>
                        English Name
                      </th>
                      <th>
                        Class
                      </th>
                      <th>
                        Created At
                    </th>
                    <th>
                      Updated At
                  </th>
                  <?php if($courses !== Null){$course = $courses[0];} ?>
                  @if ($course->trashed())
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
                      
                      @foreach ($courses as $course)
                    <td>
                        {{ $course->id }}
                    </td>
                    <td>
                        
                      <img alt="Avatar" class="table-avatar" src="{{ asset('storage/' . $course->image) }}">
            
                  </td>
                    <td>
                        <small>
                            {{ $course->name_ar }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $course->name_en }}
                      </small>
                  </td>
                  <td>
                        
                    
                    <h5 style="display: inline-block"><span class="badge badge-info">{{$course->ed_class->name_en}}</span></h5>
                        
                    
                    
                  </td>
                    <td>
                        <small>
                            {{ $course->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $course->updated_at }}
                      </small>
                  </td>
                  @if ($course->trashed())
                  <td>
                    <small>
                        {{ $course->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-actions">

                        @if (!$course->trashed())
                        @if (auth()->user()->hasPermission('courses-update'))
                        <a class="btn btn-info btn-sm" href="{{route('courses.edit' , ['lang'=>app()->getLocale() , 'course'=>$course->id])}}">
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
                        @if (auth()->user()->hasPermission('courses-restore'))

                        <a class="btn btn-info btn-sm" href="{{route('courses.restore' , ['lang'=>app()->getLocale() , 'course'=>$course->id])}}">
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
                         
                                @if ((auth()->user()->hasPermission('courses-delete'))| (auth()->user()->hasPermission('courses-trash')))

                                    <form method="POST" action="{{route('courses.destroy' , ['lang'=>app()->getLocale() , 'course'=>$course->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')  
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($course->trashed())
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
                                      @if ($course->trashed())
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

          <div class="row mt-3"> {{ $courses->appends(request()->query())->links() }}</div>
         
          @else <h3 class="pl-2">No Courses To Show</h3> 
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection