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
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{ asset('storage/images/lessons/' . $lesson->image) }}"
                     alt="User profile picture">
              </div>

            <h3 class="profile-username text-center"><span>{{'# ' . $lesson->id }}</span>{{$lesson->name_ar}}</h3>

              <p class="text-muted text-center">{{$lesson->name_en}}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Arabic Description</b> <a class="float-right">{{$lesson->description_ar}}</a>
                </li>
                <li class="list-group-item">
                  <b>English Description</b> <a class="float-right">{{$lesson->description_en}}</a>
                </li>
                <li class="list-group-item">
                  <b>Chapter</b> <a class="float-right">{{$lesson->chapter->name_en}}</a>
                </li>
              </ul>

              @if (auth()->user()->hasPermission('lessons-update'))
                        <a class="btn btn-primary btn-block" href="{{route('lessons.edit' , ['lang'=>app()->getLocale() , 'lesson'=>$lesson->id])}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
                        @else
                        <a class="btn btn-primary btn-block" href="#" aria-disabled="true">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                      </a>
                      @endif
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

        <div class="col-md-8 ">

          <div id="player"></div>

        </div><!-- end of col -->

        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->



@endsection



@push('scripts')

    <script>
        var file =
           "[Auto]{{ Storage::url('lessons/videos/' . $lesson->id . '/' . $lesson->id . '.m3u8') }}," +
            "[360]{{ Storage::url('lessons/videos/' . $lesson->id . '/' . $lesson->id . '_0_100.m3u8') }}," +
            "[480]{{ Storage::url('lessons/videos/' . $lesson->id . '/' . $lesson->id . '_1_250.m3u8') }}," +
            "[720]{{ Storage::url('lessons/videos/' . $lesson->id . '/' . $lesson->id . '_2_500.m3u8') }}";

        var player = new Playerjs({
            id: "player",
            file: file,
            poster: "{{ asset('storage/images/lessons/' . $lesson->image) }}",
            default_quality: "Auto",
        });

        


    </script>

@endpush