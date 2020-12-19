@extends('layouts.front.app')



@section('content')



<style>

.star-widget{
    text-align: center;
}

.star-widget input{
  display: none;
}
.star-widget label{
  font-size: 30px !important;
  color: #444 !important;
  padding: 10px;
  transition: all 0.2s ease;
}
input:not(:checked) ~ label:hover,
input:not(:checked) ~ label:hover ~ label{
  color: #fd4 !important;
}
input:checked ~ label{
  color: #fd4 !important;
}
input#rate-5:checked ~ label{
  color: #fe7 !important;
  text-shadow: 0 0 20px #952 !important;
}
</style>


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('My Homework Page') }}</div>
        </div>

        @php
        $homeWorkCount = 0 ;
    @endphp

    @foreach ($user->home_work_orders as $homeworkOrder)
    @if ($homeworkOrder->status == 'done')
        @php
            $homeWorkCount = $homeWorkCount + 1 ;
        @endphp
    @endif
    @endforeach

    @if ($user->home_work_orders->count() == 0 || $homeWorkCount == 0)

    <div style="padding:20px" class="row">
        <div class="col-md-6 pt-3">
            <h6>{{__('No orders in your account ..! Go to the Teachers page and choose your teacher to help you with your homework')}}</h6>
        </div>
        <div class="col-md-6">
            <a href="{{route('teachers' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id])}}" type="button" class="btn btn-outline-primary">{{ __('Teachers') }}</a>
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
                            {{__('Tacher Name')}}
                        </th>
                        <th>
                            {{__('Course')}}
                        </th>
                        <th>
                            {{__('Homework Numbers')}}
                        </th>
                        <th>
                            {{__('Action')}}
                        </th>
                    </tr>
                </thead>
                <tbody class="list order-list">

                    @foreach ($user->home_work_orders->reverse() as $homeworkOrder)
                    @if ($homeworkOrder->status == 'done')
                    <tr>
                        @php
                                    $teacher = App\User::find($homeworkOrder->teacher_id);
                        @endphp
                        <td style="width:20%; text-align:center;"><img style="width:30%" alt="Avatar" class="img-circle  table-avatar" src="{{ asset('storage/images/users/' . $teacher->profile) }}"></td>
                        <td style="">{{$teacher->name}}</td>
                        <td style="">{{ app()->getLocale() == 'ar' ? $homeworkOrder->course->name_ar : $homeworkOrder->course->name_en}} {{' - '}} {{ app()->getLocale() == 'ar' ? $homeworkOrder->course->ed_class->name_ar : $homeworkOrder->course->ed_class->name_en}}</td>
                        <td style="">{{$homeworkOrder->quantity}}</td>




                        <td>

                            <a href="{{route('homework-request' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'order' =>$homeworkOrder->id])}}" style="color:#fff; {{$homeworkOrder->quantity == 0 ? 'pointer-events: none; border: 1px solid #999999; background-color: #cccccc;' : ''}}" class="btn btn-primary btn-sm">
                                <i class="fa fa-user-graduate"></i>
                                {{__('Use')}}

                            </a>

                        </td>
                    </tr>
                    @endif
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    @endif


    <div class="page-separator pt-1 pb-1">
        <div class="page-separator__text">{{ __('Active homework') }}</div>
    </div>

    @if ($user->home_works->count() == 0)

    <div style="padding:20px" class="row">
        <div class="col-md-6 pt-3">
            <h6>{{__('You do not have active requests for help in solving your homework, if you have an order balance in your account, use it now')}}</h6>
        </div>
    </div>
    @else

    <div class="card mb-lg-32pt">

        <div class="table-responsive">

            <div class="col-md-12 pt-3">
                <h6>{{__('Dear student, you can amend your homework information in case the teacher has not received your request yet')}}</h6>
            </div>


            <table class="table mb-0 thead-border-top-0 table-nowrap">
                <thead>
                    <tr>
                        <th>

                        </th>
                        <th>
                            {{__('Tacher Name')}}
                        </th>
                        <th>
                            {{__('Homework Title')}}
                        </th>
                        <th>
                            {{__('Course')}}
                        </th>
                        <th>
                            {{__('Status')}}
                        </th>
                        <th>
                            {{__('Action')}}
                        </th>
                    </tr>
                </thead>
                <tbody class="list order-list">

                    @foreach ($user->home_works->reverse() as $homeworkRequest)
                    <tr>
                        @php
                                    $teacher = App\User::find($homeworkRequest->teacher_id);
                        @endphp
                        <td style="width:10%; text-align:center;"><img style="width:30%" alt="Avatar" class="img-circle  table-avatar" src="{{ asset('storage/images/users/' . $teacher->profile) }}"></td>
                        <td style="">{{$teacher->name}}</td>
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

                            @if ($homeworkRequest->status == 'done' && $homeworkRequest->countRating()[0] ==  '0')

                            <a data-id="{{$homeworkRequest->id}}" href="" style="color:#fff;" class=" add_rating btn btn-primary btn-sm">
                                <i class="fa fa-star"></i>
                                {{__('Rate the teacher')}}

                            </a>

                            @elseif($homeworkRequest->status != 'done')


                            @else

                            <a href="#" style="color:#fff;" class="btn btn-primary btn-sm" disabled>
                                <i class="fa fa-star"></i>
                                {{__('Rating Done')}}

                            </a>

                            @endif

                            <a href="{{route('homework-edit' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkRequest->id])}}" style="color:#fff; {{$homeworkRequest->status != 'waiting' ? 'pointer-events: none; border: 1px solid #999999; background-color: #cccccc;' : ''}}" class="btn btn-primary btn-sm btnAction" >
                                <i class="fa fa-edit"></i>
                                {{__('Edit')}}

                            </a>


                            <a href="{{route('homework-show' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkRequest->id])}}" style="color:#fff; {{($homeworkRequest->status == 'waiting' || $homeworkRequest->status == 'recieved') ? 'pointer-events: none; border: 1px solid #999999; background-color: #cccccc;' : ''}}" class="btn btn-primary btn-sm btnAction">
                                <i class="fa fa-eye"></i>
                                {{__('Show Solution')}}

                            </a>




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


@foreach ($user->home_works->reverse() as $homeworkRequest)

<div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter{{$homeworkRequest->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <form class="form" method="POST" action="{{route('homework-rating', ['lang'=> app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id , 'homeworkRequest' =>$homeworkRequest->id]  )}}" enctype="multipart/form-data">
            @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Teacher service rating')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="form-group row">
                <div class="col-md-12">

                    <div class="star-widget">
                        <input type="radio" value="5" name="rate_homework" id="rate-5" required>
                        <label for="rate-5" class="fas fa-star"></label>
                        <input type="radio" value="4" name="rate_homework" id="rate-4">
                        <label for="rate-4" class="fas fa-star"></label>
                        <input type="radio" value="3" name="rate_homework" id="rate-3">
                        <label for="rate-3" class="fas fa-star"></label>
                        <input type="radio" value="2" name="rate_homework" id="rate-2">
                        <label for="rate-2" class="fas fa-star"></label>
                        <input type="radio" value="1" name="rate_homework" id="rate-1">
                        <label for="rate-1" class="fas fa-star"></label>

                    </div>

                </div>
            </div>
            <div class="form-group row justify-content-md-center">
                <div class="col-md-10">

                    <input id="title" placeholder="{{__('What would you like to say to the teacher after serving')}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" >

                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
            </div>

        </div>
        <div class="modal-footer">

            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <button style="
                        color:#fff;
                        padding: .5rem 1rem;
                        border-radius: 5px;
                        border: none;"
                        type="submit" class=" btn-primary orderbtn">
                          {{__("Rating")}}
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
      </div>
    </div>
</div>

@endforeach





@endsection



@push('scripts-front')

<script>

$('.btnAction').on('click' , function(){



$(".btnAction").css("pointer-events", "none");

});


$('.add_rating').on('click' , function(e){


    e.preventDefault();

    var id = $(this).data('id');

    var modal = '#exampleModalCenter' + id ;


    $(modal).modal({
        keyboard: false
    });



});


$(".form").submit(function () {
        $(".orderbtn").attr("disabled", true);
});


</script>

@endpush
