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
                        <td style="">{{ app()->getLocale() == 'ar' ? $homeworkRequest->course->name_ar : $homeworkRequest->course->name_en}} {{' - '}} {{ app()->getLocale() == 'ar' ? $homeworkRequest->course->ed_class->name_ar : $homeworkRequest->course->ed_class->name_en}}</td>
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


                            @if ($homeworkRequest->status == 'waiting')
                            <a href="{{route('teacher.recieve' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkRequest->id])}}" style="color:#fff;" class="btn btn-primary btn-sm btnAction" >
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



@push('scripts-front')

<script>

$('.btnAction').on('click' , function(){



$(".btnAction").css("pointer-events", "none");

});


</script>

@endpush
