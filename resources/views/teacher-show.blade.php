@extends('layouts.front.app')



@section('content')


<style>

    .fa-star{
        color: #444 !important;
    }

    .checked{
      color: #fd4 !important;
    }

    </style>


@if ($user->type == 'student')

<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('This page does not exist') }}</div>
        </div>

        <div style="padding:20px" class="row">
            <div class="col-md-12 pt-3">
                <h6>{{__('There is an error ..! The page you requested was not found')}}</h6>
            </div>
        </div>

    </div>
</div>


@else





<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{  __('Teacher Profile - ') . $user->name }}</div>
        </div>




        <div class="row">
            <div style="text-align: center; padding-top:25px" class="col-md-4">

                @if (Auth::id() == $user->id)

                <a style="margin-bottom: 10px" class="btn btn-primary" href="{{route('profile' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}">{{__('Edit My Profile')}}</a>

                @endif

                <img src="{{ asset('storage/images/users/' . $user->profile) }}" style="width:80%"  class="img-thumbnail img-prev">
                <h3 style="padding: 10px"> {{$user->name}} </h3>
            </div>
            <div class="col-md-8">

                <div  class="container page__container" id="video_div" style="{{ $user->teacher->path == NULL ? 'display:none' : 'display:block'}}; padding-bottom:20px">



                    <div id="player"></div>



                    @push('scripts-front')

                        <script>
                            var file =
                            "[Auto]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '.m3u8') }}," +
                                "[360]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '_0_100.m3u8') }}," +
                                "[480]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '_1_250.m3u8') }}," +
                                "[720]{{ Storage::url('teachers/videos/' . $user->teacher->id . '/' . $user->teacher->id . '_2_500.m3u8') }}";

                            var player = new Playerjs({
                                id: "player",
                                file: file,
                                autoplay:1,
                                poster: "{{ $user->teacher->image == NULL ? '' : asset('storage/images/teachers/' . $user->teacher->image) }}",
                                default_quality: "Auto",
                            });


                        </script>

                    @endpush



                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p>
                    @if (app()->getLocale() == 'ar')
                    {!! $user->teacher->description_ar !!}
                    @else
                    {!! $user->teacher->description_en !!}
                    @endif
                </p>
            </div>
        </div>


        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{  __('Ratings')  }}</div>
        </div>


        <span class="heading">{{__('Rating : ')}}</span>


        @php
            $average = 0;
            $count = 0 ;
            $x = 0 ;
        @endphp
        @foreach ($requests as $request)
        @if ($request->averageRating(2)[0] != null)
        @php
            $count = $count + 1 ;
            $average = $average + $request->averageRating(2)[0];
        @endphp
        @endif
        @endforeach
        @php
            if($count == 0){
                $x = $average ;
            }else{
                $average = $average / $count ;
                $average = round($average ) ;
                $x = $average ;
            }
        @endphp
        @for ($i = 0; $i < 5; $i++)
            @if ($average > 0)
                <span class="fa fa-star checked"></span>
            @php
                $average = $average - 1
            @endphp
            @else
                <span class="fa fa-star"></span>
            @endif
        @endfor

        <p>{{__('Average : ') . $x . '/5' . ' ' . __('based on ') . $count . ' ' . __('ratings')}}</p>

        <hr style="border:3px solid #f1f1f1">

        @foreach ($requests->reverse() as $request)
        @if ($request->averageRating(2)[0] != null)

        @php
            $student_id = $request->getApprovedRatings($request->id, 'desc')[0]->author_id;


            $student = App\User::where('id' , $student_id )->first();


        @endphp


        <div class="pt-3 mb-24pt">
            <div class="d-flex mb-3">
                <a href=""
                    style=" {{app()->getLocale() == 'ar' ? 'margin-left: 10px;' : ''}} "
                class="avatar avatar-sm mr-12pt">
                    <img src="{{ asset('storage/images/users/' . $student->profile) }}" alt="people" class="avatar-img rounded-circle">
                </a>
                <div class="flex">
                    <a href=""
                    class="text-body"><strong> {{$student->name}} </strong> <small class="text-50 mr-2"> {{' ( ' . $request->getApprovedRatings($request->id, 'desc')[0]->created_at . ' ) '}} </small></a> <br>
                    <p class="mt-1 text-70"> {{$request->getApprovedRatings($request->id, 'desc')[0]->title}} </p>
                </div>
            </div>
        </div>

        @endif
        @endforeach





    </div>
</div>


@endif

@endsection
