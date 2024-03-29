@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              @if ($exam->lesson == null)
              <h1>questions - {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en}} - {{ app()->getLocale() == 'ar' ? $exam->course->name_ar : $exam->course->name_en}}</h1>
              @else
              <h1>questions - {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en}} - {{ app()->getLocale() == 'ar' ? $exam->lesson->name_ar : $exam->lesson->name_en}}</h1>
              @endif
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">questions</li>
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
                @if (auth()->user()->hasPermission('questions-create'))
                <a href="{{route('questions.create', ['lang'=> app()->getLocale() , 'country'=>$country->id , 'exam' => $exam->id] )}}"> <button type="button" class="btn btn-primary">Create question</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Create question</button></a>
                @endif
                @if (auth()->user()->hasPermission('questions-read'))
                <a href="{{route('questions.index' , ['lang'=>app()->getLocale() , 'exam'=>$exam->id , 'country'=>$country->id])}}"> <button type="button" class="btn btn-primary">questions</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">questions</button></a>
                @endif
                @if (auth()->user()->hasPermission('questions-read'))
                <a href="{{route('questions.trashed', ['lang'=> app()->getLocale() , 'country'=>$country->id , 'exam' => $exam->id]  )}}"> <button type="button" class="btn btn-primary">Trash</button></a>
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


        <h3 class="card-title">questions</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($questions->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          #id
                      </th>
                      <th>
                           Question
                      </th>
                      <th>
                        Answer Time
                      </th>
                      <th>
                        Created At
                    </th>
                    <th>
                      Updated At
                  </th>
                  <?php if($questions !== Null){$question = $questions[0];} ?>
                  @if ($question->trashed())
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

                      @foreach ($questions->reverse() as $question)
                    <td>
                        {{ $question->id }}
                    </td>
                    <td>
                        <small>
                            {{ $question->question }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $question->answer_time }}
                      </small>
                  </td>
                    <td>
                        <small>
                            {{ $question->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $question->updated_at }}
                      </small>
                  </td>
                  @if ($question->trashed())
                  <td>
                    <small>
                        {{ $question->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-actions">

                        @if (!$question->trashed())
                        @if (auth()->user()->hasPermission('questions-update'))
                        <a class="btn btn-info btn-sm" href="{{route('questions.edit' , ['lang'=>app()->getLocale() , 'question'=>$question->id , 'exam'=>$exam->id , 'country'=>$country->id])}}">
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
                        @if (auth()->user()->hasPermission('questions-restore'))

                        <a class="btn btn-info btn-sm" href="{{route('questions.restore' , ['lang'=>app()->getLocale() , 'question'=>$question->id , 'exam'=>$exam->id , 'country'=>$country->id])}}">
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

                                @if ((auth()->user()->hasPermission('questions-delete'))| (auth()->user()->hasPermission('questions-trash')))

                                    <form method="POST" action="{{route('questions.destroy' , ['lang'=>app()->getLocale() , 'question'=>$question->id , 'exam'=>$exam->id , 'country'=>$country->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($question->trashed())
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
                                      @if ($question->trashed())
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

          <div class="row mt-3"> {{ $questions->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">No questions To Show</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection
