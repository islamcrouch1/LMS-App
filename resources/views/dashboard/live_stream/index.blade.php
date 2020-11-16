@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lessons</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Lessons</li>
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
                @if (auth()->user()->hasPermission('lessons-create'))
                <a href="{{route('live_stream.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">Create Live Stream</button></a>

                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Create Lesson</button></a>

                @endif
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">

           
        <h3 class="card-title">Lessons</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        {{-- <div class="card-body p-0">
          @if($lessons->count() > 0)
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
                        Arabic Description
                   </th>
                   <th>
                     English Description
                   </th>
                      <th>
                        Chapter
                      </th>
                      <th>
                        Created At
                    </th>
                    <th>
                      Updated At
                  </th>
                  <?php if($lessons !== Null){$lesson = $lessons[0];} ?>
                  @if ($lesson->trashed())
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
                      
                      @foreach ($lessons as $lesson)
                    <td>
                        {{ $lesson->id }}
                    </td>
                    <td>
                        
                      <img alt="Avatar" class="table-avatar" src="{{ asset('storage/images/lessons/' . $lesson->image) }}">
            
                  </td>
                    <td>
                        <small>
                            {{ $lesson->name_ar }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $lesson->name_en }}
                      </small>
                  </td>
                  <td>
                    <small>
                        {{ Str::limit($lesson->description_ar , 40)  }}
                    </small>
                </td>
                <td>
                  <small>
                    {{ Str::limit($lesson->description_en , 40)  }}
                  </small>
              </td>
                  <td>
                        
                    
                    <h5 style="display: inline-block"><span class="badge badge-info">{{$lesson->chapter->name_en}}</span></h5>
                        
                    
                    
                  </td>
                    <td>
                        <small>
                            {{ $lesson->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $lesson->updated_at }}
                      </small>
                  </td>
                  @if ($lesson->trashed())
                  <td>
                    <small>
                        {{ $lesson->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-actions">

                        @if (!$lesson->trashed())
                        @if (auth()->user()->hasPermission('lessons-read'))
                        <a class="btn btn-primary btn-sm" href="{{route('lessons.display' , [app()->getLocale() , $lesson->id])}}">
                            <i class="fas fa-folder">
                            </i>
                            View
                        </a>
                        @else
                        <a class="btn btn-primary btn-sm" href="#" aria-disabled="true">
                          <i class="fas fa-folder">
                          </i>
                          View
                        </a>
                        @endif
                        @if (auth()->user()->hasPermission('lessons-update'))
                        <a class="btn btn-info btn-sm" href="{{route('lessons.edit' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id])}}">
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
                        @if (auth()->user()->hasPermission('lessons-restore'))

                        <a class="btn btn-info btn-sm" href="{{route('lessons.restore' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id])}}">
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
                         
                                @if ((auth()->user()->hasPermission('lessons-delete'))| (auth()->user()->hasPermission('lessons-trash')))

                                    <form method="POST" action="{{route('lessons.destroy' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')  
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($lesson->trashed())
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
                                      @if ($lesson->trashed())
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

          <div class="row mt-3"> {{ $lessons->appends(request()->query())->links() }}</div>
         
          @else <h3 class="pl-2">No Lessons To Show</h3> 
          @endif
        </div> --}}
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection