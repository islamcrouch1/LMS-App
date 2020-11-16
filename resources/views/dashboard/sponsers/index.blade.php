@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>sponsers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">sponsers</li>
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
                @if (auth()->user()->hasPermission('sponsers-create'))
                <a href="{{route('sponsers.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">Create sponser</button></a>

                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Create sponser</button></a>

                @endif
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">sponsers</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($sponsers->count() > 0)
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
                        URL
                    </th>
                      <th>
                        Created At
                    </th>
                    <th>
                      Updated At
                  </th>
                  <?php if($sponsers !== Null){$sponser = $sponsers[0];} ?>
                  @if ($sponser->trashed())
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

                      @foreach ($sponsers as $sponser)
                    <td>
                        {{ $sponser->id }}
                    </td>
                    <td>

                      <img alt="Avatar" class="table-avatar" src="{{ asset('storage/' . $sponser->image) }}">

                  </td>
                    <td>
                        <small>
                            {{ $sponser->name_ar }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $sponser->name_en }}
                      </small>
                  </td>
                  <td>
                    <small>
                        <a href="{{ $sponser->url }}">click</a>
                    </small>
                </td>
                    <td>
                        <small>
                            {{ $sponser->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $sponser->updated_at }}
                      </small>
                  </td>
                  @if ($sponser->trashed())
                  <td>
                    <small>
                        {{ $sponser->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-actions">

                        @if (!$sponser->trashed())
                        @if (auth()->user()->hasPermission('sponsers-update'))
                        <a class="btn btn-info btn-sm" href="{{route('sponsers.edit' , ['lang'=>app()->getLocale() , 'sponser'=>$sponser->id])}}">
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
                        @if (auth()->user()->hasPermission('sponsers-restore'))

                        <a class="btn btn-info btn-sm" href="{{route('sponsers.restore' , ['lang'=>app()->getLocale() , 'sponser'=>$sponser->id])}}">
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

                                @if ((auth()->user()->hasPermission('sponsers-delete'))| (auth()->user()->hasPermission('sponsers-trash')))

                                    <form method="post" action="{{route('sponsers.destroy' , ['lang'=>app()->getLocale() , 'sponser'=>$sponser->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($sponser->trashed())
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
                                      @if ($sponser->trashed())
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

          <div class="row mt-3"> {{ $sponsers->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">No sponsers To Show</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection
