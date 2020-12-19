@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Withdrawals')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('Withdrawals')}}</li>
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
              <div class="col-md-3">
                <div class="form-group">
                <input type="text" name="search" autofocus placeholder="{{__('Search By Teacher Name ..')}}" class="form-control" value="{{request()->search}}">
                </div>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="country_id" style="display:inline-block">
                  <option value="" selected>{{__('All Countries')}}</option>
                  @foreach ($countries as $country)
                  <option value="{{$country->id}}" {{ request()->country_id == $country->id ? 'selected' : ''}}>{{app()->getLocale() == 'ar' ?  $country->name_ar : $country->name_en}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="status" style="display:inline-block">
                  <option value="" selected>{{__('All Status')}}</option>
                    <option value="waiting" {{request()->status == 'waiting' ? 'selected' : ''}}>{{__('Awaiting review from management')}}</option>
                    <option value="recieved" {{request()->status == 'recieved' ? 'selected' : ''}}>{{__('Your request has been received and is being reviewed for a deposit')}}</option>
                    <option value="done" {{request()->status == 'done' ? 'selected' : ''}}>{{__('The amount has been deposited into your account')}}</option>
                </select>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
                {{-- @if (auth()->withdraw()->hasPermission('withdrawals-create'))
                <a href="{{route('withdrawals.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">{{__('Create withdraw')}}</button></a>
                @else
                <a href="#" disabled> <button type="button" class="btn btn-primary">{{__('Create withdraw')}}</button></a>
                @endif --}}
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">{{__('Withdrawals')}}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($withdrawals->count() > 0)
          <table class="table table-striped projects">
              <thead>

                  <tr>

                    <th class="text-center">#id</th>
                    <th class="text-center">{{__('Profile')}}</th>
                    <th class="text-center">{{__('Teacher Name')}}</th>
                    <th class="text-center">{{__('Requested Amount')}}</th>
                    <th class="text-center">{{__('Status')}}</th>
                    <th class="text-center">{{__('Created At')}}</th>
                    <th class="text-center">{{__('Updated At')}}</th>
                    <th class="text-center">{{__('Actions')}}</th>

                  </tr>

              </thead>

              <tbody>

                  <tr>

                    @foreach ($withdrawals->reverse() as $withdraw)

                    @if (auth()->user()->hasRole('superadministrator') || auth()->user()->monitor->countries()->where('country_id', $withdraw->country_id)->first() != null || auth()->user()->monitor->teachers()->where('user_id', $withdraw->user_id)->first() != null)


                    <td  class="text-center">{{ $withdraw->id }}</td>
                    <td  class="text-center"><img alt="Avatar" class="table-avatar" src="{{ asset('storage/images/users/' . $withdraw->user->profile) }}"></td>
                    <td  class="text-center"><small><a href="{{route('users.show' , [app()->getLocale() , $withdraw->user->id])}}">
                        {{ $withdraw->user->name }}
                    </a></small></td>
                    <td  class="text-center">{{ $withdraw->amount . ' ' .  $withdraw->user->country->currency}}</td>
                    <td class="project-state">
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
                    <td  class="text-center"><small>{{ $withdraw->created_at }}</small></td>
                    <td  class="text-center"><small>{{ $withdraw->updated_at }}</small></td>
                    <td class="project-actions">

                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg-{{$withdraw->id}}">
                            {{__('Bank Information')}}
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary-{{$withdraw->id}}">
                            {{__('Change Request Status')}}
                        </button>

                    </td>
                </tr>
                        @endif
                      @endforeach


              </tbody>
          </table>

          <div class="row mt-3"> {{ $withdrawals->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">{{__('No withdrawals To Show')}}</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


    @foreach ($withdrawals->reverse() as $withdraw)


    <div class="modal fade" id="modal-lg-{{$withdraw->id}}">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 style="direction: rtl;" class="modal-title">{{__('Bank Information For - ') . $withdraw->user->name}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <ul class="list-group">
                  <li dir="rtl" class="list-group-item p-2">{{__('Full Name : ')}}{{$withdraw->user->bank_information->full_name}}</li>
                  <li dir="rtl" class="list-group-item p-2">{{__('Bank Name : ')}}{{$withdraw->user->bank_information->bank_name}}</li>
                  <li dir="rtl" class="list-group-item p-2">{{__('Bank Account Number : ')}}{{$withdraw->user->bank_information->bank_account_number}}</li>
                  <li dir="rtl" class="list-group-item p-2">{{__('The date of last update : ')}}{{$withdraw->user->bank_information->updated_at}}</li>
                  <li dir="rtl" class="list-group-item p-2"><img src="{{asset('storage/images/bankinformation/' . $withdraw->user->bank_information->image1)}}" ></li>
                  <li dir="rtl" class="list-group-item p-2"><img src="{{asset('storage/images/bankinformation/' . $withdraw->user->bank_information->image2)}}" ></li>

              </ul>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{__('Close')}}</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="modal-primary-{{$withdraw->id}}">
        <div class="modal-dialog">
          <div class="modal-content bg-primary">
            <div class="modal-header">
              <h4 style="direction: rtl;" class="modal-title">{{__('Change Request Status for - ') . $withdraw->user->name}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="{{route('withdrawals.update', ['lang'=> app()->getLocale() , 'withdrawal'=>$withdraw->id ])}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label">{{ __('Select Status') }}</label>
                        <div class="col-md-8">
                            <select style="height: 50px;" class=" form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required autocomplete="status">
                                <option value="waiting" {{$withdraw->status == 'waiting' ? 'selected' : ''}}>{{__('Awaiting review from management')}}</option>
                                <option value="recieved" {{$withdraw->status == 'recieved' ? 'selected' : ''}}>{{__('Your request has been received and is being reviewed for a deposit')}}</option>
                                <option value="done" {{$withdraw->status == 'done' ? 'selected' : ''}}>{{__('The amount has been deposited into your account')}}</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-outline-light">{{__('Save changes')}}</button>
                </div>

            </form>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

      @endforeach


  @endsection

