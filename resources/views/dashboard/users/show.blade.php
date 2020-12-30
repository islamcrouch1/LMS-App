@extends('layouts.dashboard.app')

@section('adminContent')



   <!-- Main content -->
   <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 m-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{ asset('storage/images/users/' . $user->profile) }}"
                     alt="User profile picture">
              </div>

            <h3 class="profile-username text-center"><span>{{'# ' . $user->id }}</span>{{$user->name}}</h3>

              <p class="text-muted text-center">{{$user->type}}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Email</b> <a class="float-right">{{$user->email}}</a>
                </li>
                <li class="list-group-item">
                  <b>Country</b> <a class="float-right">{{$user->country->name_en}}</a>
                </li>
                <li class="list-group-item">
                  <b>Phone</b> <a class="float-right">{{$user->phone}}</a>
                </li>
                <li class="list-group-item">
                    <b>Gender</b> <a class="float-right">{{$user->gender}}</a>
                </li>
                <li class="list-group-item">
                    <b>Verification Code</b> <a class="float-right">{{$user->verification_code}}</a>
                </li>
                <li class="list-group-item">
                    <b>Wallet Balance</b> <a class="float-right">{{$user->wallet->balance . ' ' . $user->country->currency}}</a>
                </li>
                <li class="list-group-item">
                    <b>Created At</b> <a class="float-right">{{$user->created_at}}</a>
                  </li>
              </ul>

              <a href="{{route('users.edit' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}" class="btn btn-primary btn-block"><b>Edit</b></a>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-12">


            <div style="{{app()->getLocale() == 'ar' ? 'direction:rtl; text-align:right;' : ''}}" class="page-section">
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

        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->



@endsection
