@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">




        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Active homework') }}</div>
        </div>

    @if ($homeWorks->count() == 0)

    <div style="padding:20px" class="row">
        <div class="col-md-6 pt-3">
            <h6>{{__('You have no active homework help requests')}}</h6>
        </div>
    </div>
    @else

    <div class="card mb-lg-32pt">

        <div class="table-responsive">


            <table class="table mb-0 thead-border-top-0 table-nowrap">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>
                            {{__('Student Name')}}
                        </th>
                        <th>
                            {{__('Homework Title')}}
                        </th>
                        <th>
                            {{__('Course')}}
                        </th>
                        <th>
                            {{__('Request Status')}}
                        </th>
                        <th>
                            {{__('Action')}}
                        </th>
                    </tr>
                </thead>
                <tbody class="list order-list">

                    @foreach ($homeWorks->reverse() as $homeworkRequest)
                    <tr>

                        <td style="width:10%; text-align:center;"><img style="width:30%" alt="Avatar" class="img-circle  table-avatar" src="{{ asset('storage/images/users/' . $homeworkRequest->user->profile) }}"></td>
                        <td style="">{{$homeworkRequest->user->name}}</td>
                        <td style="">{{$homeworkRequest->homework_title}}</td>
                        <td style="">
                            {{ app()->getLocale() == 'ar' ? $homeworkRequest->course->name_ar : $homeworkRequest->course->name_en}} {{' - '}} {{ app()->getLocale() == 'ar' ? $homeworkRequest->course->ed_class->name_ar : $homeworkRequest->course->ed_class->name_en}}

                            <br>

                            @if ($homeworkRequest->home_work_order->homework_services->count() == '0')
                                <span class="badge badge-info badge-lg">{{__('Normal Homework')}}</span>
                            @else
                                @foreach ($homeworkRequest->home_work_order->homework_services as $homework_service)
                                    <span class="badge badge-info badge-lg">{{app()->getLocale() == 'ar' ? $homework_service->name_ar : $homework_service->name_en}}</span>
                                @endforeach
                            @endif

                        </td>
                        <td style="">

                            @switch($homeworkRequest->status)
                            @case('waiting')
                            <span class="badge badge-info badge-lg">{{__('Waiting to receive the request from the teacher')}}</span>
                                @break
                            @case('done')
                            <span class="badge badge-info badge-lg">{{__('Completed Request')}}</span>
                                @break
                            @case('recieved')
                            <span class="badge badge-info badge-lg">{{__('Request Recieved')}}</span>
                                @break
                            @case('solution')
                            <span class="badge badge-info badge-lg">{{__('The solution is ready')}}</span>
                                @break
                            @case('rejected')
                            @if ($homeworkRequest->home_work_order->status == 'canceled')
                            <span class="badge badge-danger badge-lg">{{__('the request has been canceled')}}</span>
                            @else
                            <span class="badge badge-danger badge-lg">{{__('reques has been rejected')}}</span>
                            @endif
                                @break
                            @default
                            @endswitch

                        </td>




                        <td>

                            <style>
                                .button {
                                    background-color: #1c87c9;
                                    -webkit-border-radius: 60px;
                                    border-radius: 60px;
                                    border: none;
                                    color: #eeeeee;
                                    cursor: pointer;
                                    display: inline-block;
                                    font-family: sans-serif;
                                    font-size: 20px;
                                    padding: 10px 10px;
                                    text-align: center;
                                    text-decoration: none;
                                }
                                @keyframes glowing {
                                    0% {
                                    background-color: #5567ff;
                                    box-shadow: 0 0 5px #5567ff;
                                    }
                                    50% {
                                    background-color: #828ffe;
                                    box-shadow: 0 0 20px #828ffe;
                                    }
                                    100% {
                                    background-color: #5567ff;
                                    box-shadow: 0 0 5px #5567ff;
                                    }
                                }
                                .button {
                                    animation: glowing 1300ms infinite;
                                }
                            </style>


                            @if ($homeworkRequest->status != 'rejected')

                                @if ($homeworkRequest->status == 'waiting')
                                <a href="#" style="color:#fff;" class="btn btn-primary btn-sm show_details" data-select="{{$homeworkRequest->id}}" >
                                    <i class="fa fa-edit"></i>
                                    {{__('Receive the request')}}
                                </a>
                                @else


                                    @if (isset($homeworkRequest1->id))



                                    <a  href="{{route('teacher.interact' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkRequest->id])}}" style="color:#fff;" class="btn btn-primary btn-sm btnAction {{$homeworkRequest->id == $homeworkRequest1->id ? 'button' : ''}} " >
                                        <i class="fa fa-edit"></i>
                                        {{__('Interact with the application')}}
                                    </a>
                                    @else
                                    <a  href="{{route('teacher.interact' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkRequest->id])}}" style="color:#fff;" class="btn btn-primary btn-sm btnAction" >
                                        <i class="fa fa-edit"></i>
                                        {{__('Interact with the application')}}
                                    </a>
                                    @endif

                                @endif

                            @elseif ($homeworkRequest->status == 'rejected')

                            <a href="#" style="color:#fff;" class="btn btn-primary btn-sm show_details" data-select="{{$homeworkRequest->id}}" >
                                <i class="fa fa-eye"></i>
                                {{__('Request Details')}}
                            </a>

                            @endif


                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    @endif



    </div>
</div>









@endsection

@foreach ($homeWorks->reverse() as $homeworkRequest)

@if ($homeworkRequest->status != 'rejected')


<div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter2-{{$homeworkRequest->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">


        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{$homeworkRequest->homework_title}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="text-align:{{app()->getLocale() == 'ar' ? 'right' : 'left' }}">

            @if ($homeworkRequest->home_work_order->homework_services->count() == '0')
                <span class="badge badge-info badge-lg m-2">{{__('Normal Homework')}}</span>
            @else
                @foreach ($homeworkRequest->home_work_order->homework_services as $homework_service)
                    <span class="badge badge-info badge-lg m-2">{{app()->getLocale() == 'ar' ? $homework_service->name_ar : $homework_service->name_en}}</span>
                @endforeach
            @endif

            <h5 class="card-title" style="text-align:{{app()->getLocale() == 'ar' ? 'right' : 'left' }}">{{ $homeworkRequest->homework_title}}</h5>
            <p class="card-text" style="text-align:{{app()->getLocale() == 'ar' ? 'right' : 'left' }}">{!! $homeworkRequest->student_note !!}</p>
            <div class="form-group row">
                <div class="col-md-10">
                    @if ($homeworkRequest->student_image != '#')
                    <img src="{{ asset('storage/images/homework/' . $homeworkRequest->student_image) }}" style="width:350px"  class="img-thumbnail img-prev">
                    @endif
                </div>
            </div>
            <div style="text-align: center;">
                <a href="{{ $homeworkRequest->student_file == '#' ? '#' : asset('storage/homework/files/' . $homeworkRequest->student_file) }}" class="btn btn-primary">{{ $homeworkRequest->student_file == '#' ? __('No file attached') : __('Download File') }}</a>
            </div>

        </div>
        <div class="modal-footer">

            <div class="container">
                <div class="row">
                    <div class="col-md-6" style="text-align: center;">
                        <a href="{{route('teacher.recieve' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkRequest->id])}}" style="color:#fff;" class="btn btn-success btn-sm btnAction" >
                            <i class="fa fa-check"></i>
                            {{__('Receive the request')}}
                        </a>
                    </div>

                    <div class="col-md-6" style="text-align: center;">

                        <a href="{{route('teacher.reject' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkRequest->id])}}" style="color:#fff;" class="btn btn-danger btn-sm btnAction" >
                            <i class="fa fa-times-circle"></i>
                            {{__('Reject the request')}}
                        </a>
                    </div>
                </div>
            </div>

        </div>
      </div>
    </div>
</div>

@elseif ($homeworkRequest->status == 'rejected')

<div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter2-{{$homeworkRequest->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">


        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{$homeworkRequest->homework_title}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="text-align:{{app()->getLocale() == 'ar' ? 'right' : 'left' }}">

            <h5 class="card-title" style="text-align:{{app()->getLocale() == 'ar' ? 'right' : 'left' }}">{{ $homeworkRequest->homework_title}}</h5>
            <p class="card-text" style="text-align:{{app()->getLocale() == 'ar' ? 'right' : 'left' }}">{!! $homeworkRequest->student_note !!}</p>
            <div class="form-group row">
                <div class="col-md-10">
                    @if ($homeworkRequest->student_image != '#')
                    <img src="{{ asset('storage/images/homework/' . $homeworkRequest->student_image) }}" style="width:350px"  class="img-thumbnail img-prev">
                    @endif
                </div>
            </div>
            <div style="text-align: center;">
                <a href="{{ $homeworkRequest->student_file == '#' ? '#' : asset('storage/homework/files/' . $homeworkRequest->student_file) }}" class="btn btn-primary">{{ $homeworkRequest->student_file == '#' ? __('No file attached') : __('Download File') }}</a>
            </div>

        </div>
        <div class="modal-footer">



        </div>
      </div>
    </div>
</div>


@endif

@endforeach



@push('scripts-front')

<script>

$('.btnAction').on('click' , function(){



$(".btnAction").css("pointer-events", "none");

});



$('.show_details').on('click' , function(e){

var selectid = $(this).data('select');


e.preventDefault();

$('#exampleModalCenter2-' + selectid).modal({
    keyboard: false
    });

});


</script>

@endpush
