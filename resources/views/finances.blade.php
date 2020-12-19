@extends('layouts.front.app')



@section('content')


<div class="page-section">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Finances') }}</div>
        </div>

        @php
        $OutstandingBalance = 0 ;
        $countH = 0 ;
        $balanceCount = 0;
        $balance = 0 ;
        $amount = 0;
        @endphp

        @foreach ($user->withdraws as $withdraw)
        @php
            $amount = $amount + $withdraw->amount
        @endphp
        @endforeach

        @foreach ($orders->reverse() as $homeworkOrder)
        @if ($homeworkOrder->status == 'done')
            @php

                $balanceCount = 0;
                $countH = 0;
                $commision = 0;

                foreach ($homeworkOrder->home_works as $homeWorkRequset) {
                    if($homeWorkRequset->status != 'done'){
                        $countH = $countH + 1;
                    }
                    if($homeWorkRequset->status == 'done'){
                        $balanceCount = $balanceCount + 1;
                    }
                }
                $commision = ($homeworkOrder->quantity + $countH ) * $homeworkOrder->course->teacher_commission;
                $OutstandingBalance = $OutstandingBalance + $commision ;

                $balance = $balance + ($balanceCount * $homeworkOrder->course->teacher_commission) ;


            @endphp
        @endif
        @endforeach



        <div class="row">
            <div class="col-lg-4">
                <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                    <div class="card-body">
                        <h4 class="h2 mb-0">{{ $OutstandingBalance . ' ' . $user->country->currency }}</h4>
                        <div>{{__('Outstanding Balance')}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-center mb-lg-0">
                    <div class="card-body">
                        <h4 class="h2 mb-0">{{ $balance . ' ' . $user->country->currency }}</h4>
                        <div>{{__('Your total previous profits')}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card text-center mb-lg-0">
                    <div class="card-body">
                        <h4 class="h2 mb-0">{{ $balance - $amount . ' ' . $user->country->currency }}</h4>
                        <div>{{__('Withdrawable Profits')}}</div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row pt-3">
            <div class="col-md-12">
                <a id="bank_informations" href="" type="button" class="btn btn-outline-primary">{{__('Your Bank Information')}}</a>
                <a id="withdraw" href="" type="button" class="btn btn-outline-primary">{{__('Balance withdrawal request')}}</a>

            </div>
        </div>


    </div>
</div>




<div class="page-section">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Homework Orders') }}</div>
        </div>


    @php
    $homeWorkCount = 0 ;
    @endphp

    @foreach ($orders->reverse() as $homeworkOrder)
    @if ($homeworkOrder->status == 'done')
        @php
            $homeWorkCount = $homeWorkCount + 1 ;
        @endphp
    @endif
    @endforeach

    @if ($orders->count() == 0 || $homeWorkCount == 0)

    <div style="padding:20px" class="row">
        <div class="col-md-12 pt-3">
            <h6>{{__('No Homeworks orders in your account ..!')}}</h6>
        </div>
    </div>
    @else

    <div class="card mb-lg-32pt">

        <div class="table-responsive">


            <table class="table mb-0 thead-border-top-0 table-nowrap">
                <thead>
                    <tr>
                        <th>
                            {{__('Order No')}}
                        </th>
                        <th>
                            {{__('Total')}}
                        </th>
                        <th>
                            {{__('Teacher Commision')}}
                        </th>
                        <th>
                            {{__('Course')}}
                        </th>
                        <th>
                            {{__('Student Name')}}
                        </th>
                        <th>
                            {{__('Order Date')}}
                        </th>
                        <th>
                            {{__('Action')}}
                        </th>
                    </tr>
                </thead>
                <tbody class="list order-list">

                    @foreach ($orders->reverse() as $homeworkOrder)
                    @if ($homeworkOrder->status == 'done')
                    @php
                    $countc = 0 ;
                    foreach ($homeworkOrder->home_works as $homeWorkRequset) {
                            $countc = $countc + 1;
                    }
                    @endphp
                    <tr>
                        <td style="">{{$homeworkOrder->id}}</td>
                        <td style="">{{$homeworkOrder->total_price}} {{' ' . $user->country->currency}}</td>
                        <td style="">{{$homeworkOrder->course->teacher_commission *  ($homeworkOrder->quantity + $countc )}} {{' ' . $user->country->currency}}</td>
                        <td style="">{{ app()->getLocale() == 'ar' ? $homeworkOrder->course->name_ar : $homeworkOrder->course->name_en}}</td>
                        <td style="">{{$homeworkOrder->user->name}}</td>
                        <td style="">{{$homeworkOrder->created_at}}</td>




                        <td>

                            <a href="{{route('teacher.homework' , ['lang'=>app()->getLocale() , 'user'=>Auth::id() ,  'country'=>$scountry->id])}}" style="color:#fff;" class="btn btn-primary btn-sm">
                                <i class="fa fa-user-graduate"></i>
                                {{__('Check Active Requests')}}

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





    </div>
</div>


<div class="page-section">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Balance withdrawal requests') }}</div>
        </div>


        @if ($user->withdraws->count() == 0)

        <div style="padding:20px" class="row">
            <div class="col-md-12 pt-3">
                <h6>{{__('You have no recorded profit withdrawal requests')}}</h6>
            </div>
        </div>
        @else

        <div class="card mb-lg-32pt">

            <div class="table-responsive">
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>
                                {{__('Order No')}}
                            </th>
                            <th>
                                {{__('Total')}}
                            </th>
                            <th>
                                {{__('Order Date')}}
                            </th>
                            <th>
                                {{__('Order status')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list order-list">

                        @foreach ($user->withdraws->reverse() as $withdraw)
                        <tr>
                            <td style="">{{$withdraw->id}}</td>
                            <td style="">{{$withdraw->amount}} {{' ' . $user->country->currency}}</td>
                            <td style="">{{$withdraw->created_at}}</td>
                            <td style="">

                                @switch($withdraw->status)
                                @case('waiting')
                                <span class="badge badge-success badge-lg">{{__('Awaiting review from management')}}</span>
                                    @break
                                @case('recieved')
                                <span class="badge badge-success badge-lg">{{__('Your request has been received and is being reviewed for a deposit')}}</span>
                                    @break
                                @case('done')
                                <span class="badge badge-success badge-lg">{{__('The amount has been deposited into your account')}}</span>
                                    @break
                                @default
                                @endswitch


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





<div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <form method="POST" action="{{route('finances.withdraw', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id ]  )}}" enctype="multipart/form-data">
            @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Balance withdrawal request')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


            <div class="form-group row">
                <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('The amount to be withdrawn') }}</label>

                <div class="col-md-8">
                    <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $balance - $amount }}" required autocomplete="amount"  readonly>

                    @error('amount')
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
                    <div class="col-md-4">
                        <a style="color:#fff" type="submit" class="btn btn-primary orderbtn btnAction">
                          {{__("Confirm order")}}
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
      </div>
    </div>
</div>

@endsection


<div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <form method="POST" action="{{route('finances.bankinformation', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id ]  )}}" enctype="multipart/form-data">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{__('Dear teacher, please write your bank account information accurately')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="form-group row">
                    <label for="full_name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                    <div class="col-md-8">
                        <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ $user->bank_information->full_name }}" required autocomplete="full_name" >

                        @error('full_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label for="bank_name" class="col-md-4 col-form-label text-md-right">{{ __('Bank Name') }}</label>

                    <div class="col-md-8">
                        <input id="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ $user->bank_information->bank_name }}" required autocomplete="bank_name" >

                        @error('bank_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label for="bank_account_number" class="col-md-4 col-form-label text-md-right">{{ __('Bank Account Number') }}</label>

                    <div class="col-md-8">
                        <input id="bank_account_number" type="text" class="form-control @error('bank_account_number') is-invalid @enderror" name="bank_account_number" value="{{ $user->bank_information->bank_account_number }}" required autocomplete="bank_account_number" >

                        @error('bank_account_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>




                <div class="form-group row">
                    <label for="image1" class="col-md-4 col-form-label text-md-right">{{ __('ID card from the front') }}</label>

                    <div class="col-md-8">
                        <input id="image1" type="file" class="form-control-file img @error('image1') is-invalid @enderror" name="image1" value="{{ old('image1') }}">

                        @error('image1')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-8">
                        <img src="{{ $user->bank_information->image1 == Null ? ' ' : asset('storage/images/bankinformation/' . $user->bank_information->image1 ) }}" style="width:200px"  class="img-thumbnail img-prev">
                    </div>
                </div>



                <div class="form-group row">
                    <label for="image2" class="col-md-4 col-form-label text-md-right">{{ __('ID card from the back') }}</label>

                    <div class="col-md-8">
                        <input id="image2" type="file" class="form-control-file img1 @error('image2') is-invalid @enderror" name="image2" value="{{ old('image2') }}">

                        @error('image2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-10">
                        <img src="{{ $user->bank_information->image2 == Null ? ' ' : asset('storage/images/bankinformation/' . $user->bank_information->image2 ) }}" style="width:200px"  class="img-thumbnail img-prev1">
                    </div>
                </div>






            </div>
            <div class="modal-footer">

                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <a style="color:#fff" type="submit" class="btn btn-primary orderbtn btnAction">
                            {{__("Save")}}
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </form>

      </div>
    </div>
</div>



@push('scripts-front')

<script>


    $('#bank_informations').on('click' , function(e){


    e.preventDefault();

    $('#exampleModalCenter2').modal({
            keyboard: false
        });

    });


    $('#withdraw').on('click' , function(e){


        e.preventDefault();

        $('#exampleModalCenter1').modal({
                keyboard: false
            });

        });

$('.btnAction').on('click' , function(){



$(".btnAction").css("pointer-events", "none");

});


</script>

@endpush
