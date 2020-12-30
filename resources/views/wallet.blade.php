@extends('layouts.front.app')



@section('content')


<div class="page-section">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Wallet') }}</div>
        </div>


        <div class="row">
            @if (Auth::user()->type == 'teacher')
            <div class="col-md-12">
                <h5>
                    {{__('Dear teacher, this wallet is for your purchases from the site and has nothing to do with the balance of providing your services with us.')}}
                </h5>
            </div>
            @endif
            <div class="col-lg-4">
                <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                    <div class="card-body">
                        <h4 class="h2 mb-0">{{ $user->wallet->balance . ' ' . $user->country->currency}}</h4>
                        <div>{{__('Wallet')}}</div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row pt-3">
            <div class="col-md-12">
                <a id="bank_informations" href="" type="button" class="btn btn-outline-primary">{{__('Add Balance To Your Wallet')}}</a>
            </div>
        </div>


    </div>
</div>


<div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <form method="POST" action="{{route('wallet.add', ['lang'=> app()->getLocale() , 'country'=>$scountry->id , 'user'=>$user->id]  )}}" enctype="multipart/form-data">
            @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Specify the order details')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="form-group row">
                <label for="course" class="col-md-6 col-form-label">{{ __('Enter Required Balance') }}</label>
                <div class="col-md-6">

                    <input id="balance" type="number" class="form-control @error('balance') is-invalid @enderror" name="balance"  min="1" value="1"  autocomplete="balance">

                </div>
            </div>

        </div>
        <div class="modal-footer">

            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <a style="color:#fff" type="submit" class="btn btn-primary orderbtn">
                          {{__("Pay Now")}}
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
      </div>
    </div>
</div>


<div style="" class="page-section">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Wallet Processes') }}</div>
        </div>

        @php
            $wallet_count = 0 ;
        @endphp


        @foreach ($wallet_requests as $wallet_request)
        @if ($wallet_request->status == 'done')

            @php
                $wallet_count = $wallet_count + 1 ;
            @endphp
        @endif
        @endforeach

        @if ($user->wallet_requests->count() == 0 || $wallet_count == 0)

        <div style="padding:20px" class="row">
            <div class="col-md-6 pt-3">
                <h6>{{__('There are no previous transactions performed on your wallet')}}</h6>
            </div>
        </div>
        @else

        <div class="card mb-lg-32pt">

            <div class="table-responsive">


                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>
                                {{__('Process ID')}}
                            </th>
                            <th>
                                {{__('Process')}}
                            </th>
                            <th>
                                {{__('Balance')}}
                            </th>
                            <th>
                                {{__('Process Date')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list order-list">

                        @foreach ($wallet_requests->reverse() as $wallet_request)
                        @if ($wallet_request->status == 'done')
                        <tr>
                            <td style="">{{$wallet_request->id}}</td>
                            <td style="">{{ app()->getLocale() == 'ar' ? $wallet_request->request_ar : $wallet_request->request_en}}</td>
                            <td style="">{{$wallet_request->balance}} {{' ' . $user->country->currency}}</td>
                            <td style="">{{$wallet_request->created_at}}</td>
                        </tr>
                        @endif
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
        <div class="row mt-3"> {{ $wallet_requests->appends(request()->query())->links() }}</div>





    @endif




    </div>
</div>

@endsection


@push('scripts-front')

<script>



$('#bank_informations').on('click' , function(e){

    e.preventDefault();

    $('#exampleModalCenter2').modal({
        keyboard: false
        });

});



    </script>

@endpush
