@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Addresses') }}</div>
        </div>

        @if ($user->addresses->count() > 0)
            <div style="padding:20px" class="row">
                <div class="col-md-6">
                    <a href="{{route('user.addresses.create', ['lang'=>app()->getLocale() , 'user'=>$user->id , 'country'=>$scountry->id]  )}}" type="button" class="btn btn-outline-primary">{{__('Add New Address')}}</a>
                </div>
            </div>
        @endif

        @if ($user->addresses->count() == 0)
        <div style="padding:20px" class="row">
            <div class="col-md-6 pt-3">
                <h6>{{__('Your Addresses List is empty..! Please add at least one address to make order')}}</h6>
            </div>
            <div class="col-md-6">
                <a href="{{route('user.addresses.create', ['lang'=>app()->getLocale() , 'user'=>$user->id , 'country'=>$scountry->id]  )}}" type="button" class="btn btn-outline-primary btn-lg">{{__('Add New Address')}}</a>
            </div>
        </div>
        @else

        <div class="card mb-lg-32pt">

            <div class="table-responsive">


                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>
                                {{__('Address')}}
                            </th>
                            <th>
                                {{__('Action')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list order-list">

                        @foreach ($user->addresses as $address)
                        <tr>
                            <td style="width:70%;">{{ app()->getLocale() == 'ar' ? $user->country->name_ar : $user->country->name_en}} {{'-' .  $address->province . '-' . $address->city . '-' . $address->district . '-' . $address->street . '-' . $address->building . '-' . $address->phone . '-' . $address->notes . '-' }}</td>
                            <td>

                                <a class="btn btn-info btn-sm" href="{{route('user.addresses.edit' , ['lang'=>app()->getLocale() , 'address'=>$address->id , 'user'=>$user->id , 'country'=>$scountry->id])}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    {{__('Edit')}}
                                </a>

                                <form method="POST" action="{{route('user.addresses.destroy' , ['lang'=>app()->getLocale() , 'address'=>$address->id , 'user'=>$user->id , 'country'=>$scountry->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                    @csrf
                                    @method('GET')
                                            <button type="submit" class="btn btn-danger btn-sm delete">
                                                <i class="fas fa-trash">
                                                </i>
                                                {{ __('Delete') }}
                                            </button>
                                </form>
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
