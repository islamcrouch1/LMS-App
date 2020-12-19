@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Cart') }}</div>
        </div>

        @if ($user->cart->products->count() > 0)
            <div style="padding:20px" class="row">
                <div class="col-md-6 pt-2">
                    <h6>{{__('Need more products..! Go to library now')}}</h6>
                </div>
                <div class="col-md-6">
                    <a href="{{route('library' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id])}}" type="button" class="btn btn-outline-primary">{{__('Library')}}</a>
                </div>
            </div>
        @endif

        @if ($user->cart->products->count() == 0)
        <div style="padding:20px" class="row">
            <div class="col-md-6 pt-3">
                <h6>{{__('Your cart is empty..! Go to add some amazing products')}}</h6>
            </div>
            <div class="col-md-6">
                <a href="{{route('library' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id])}}" type="button" class="btn btn-outline-primary btn-lg">{{__('Library')}}</a>
            </div>
        </div>
        @else

        <div class="card mb-lg-32pt">

            <form action="{{ route('order.adding',  ['lang'=>app()->getLocale() , 'user'=>$user->id ,'country'=>$scountry->id]) }}" method="post" id="cartform">
                @csrf

            <div class="table-responsive">


                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>
                            </th>
                            <th>
                                {{__('Product')}}
                            </th>

                            <th>
                                {{__('Price')}}
                            </th>
                            <th>
                                {{__('Quantity')}}
                            </th>
                            <th>
                                {{__('Delete')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list order-list">

                        @foreach ($user->cart->products as $product)
                        <tr>
                            <td style="width:20%; text-align:center;"><img style="width:30%" alt="Avatar" class="table-avatar" src="{{ asset('storage/images/products/' . $product->image) }}"></td>
                            <td>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</td>
                            <td class="product-price">{{$product->sale_price  . ' ' . $product->country->currency}}</td>
                            <td><input style="width:50%" type="number" name="products[{{$product->id}}][quantity]" data-stock="{{$product->stock}}" data-price="{{$product->sale_price}}" class="form-control input-sm product-quantity" min="1" value="1"></td>
                            <td><a href="{{ route('cart.remove',['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'product'=>$product->id , 'country'=>$scountry->id ] ) }}" class="btn btn-danger btn-sm remove-product-btn"><span class="fa fa-trash"></span></a></td>



                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <h4 style="padding:10px">{{__('Total : ')}}<span class="total-price">
                    @php
                        $productsPrice = 0;
                    @endphp
                    @foreach ($user->cart->products as $product)
                    @php
                       $productsPrice = $productsPrice  + floatval($product->sale_price);
                    @endphp
                    @endforeach
                    {{$productsPrice  . ' ' . $user->country->currency}}
                </span></h4>
            </div>

        </div>


        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Select Address') }}</div>
        </div>


        @if ($user->addresses->count() > 0)
        <div style="padding:20px" class="row">
            <div class="col-md-12 pt-3">
                <h6>{{__('Select From old Addresse')}}</h6>
            </div>
            <div class="col-md-12">
                <select style="margin-bottom: 20px" class="form-control form-control-lg" id="address_id" name="address_id" required>
                    @foreach ($user->addresses as $address)
                    <option value="{{$address->id}}">{{ app()->getLocale() == 'ar' ? $user->country->name_ar : $user->country->name_en}} {{'-' .  $address->province . '-' . $address->city . '-' . $address->district . '-' . $address->street . '-' . $address->building . '-' . $address->phone . '-' . $address->notes . '-' }}</option>
                    @endforeach
                </select>
                <span style="padding:5px">{{__('OR')}}</span>
                <a href="{{route('addresses' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id])}}" type="button" class="btn btn-outline-info btn-sm">{{__('Add New Address ')}}</a>
            </div>
        </div>

        @else
        <div style="padding:20px" class="row">
            <div class="col-md-12 pt-3">
                <h6>{{__('No Addresse to select')}}</h6>
                <a href="{{route('addresses' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id])}}" type="button" class="btn btn-outline-info">{{__('Add New Address')}}</a>
            </div>

        </div>
        @endif

        <button
        style="
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: 1px solid transparent;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;"
         class=" btn-primary btn-block" id="add-order-form-btn" {{$user->addresses->count() == 0  ? 'disabled' : '' }} ><i style="padding:7px" class="fa fa-plus"></i> {{__('Add order')}}</button>

    </form>
    @endif




    </div>
</div>


<div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{__("The required quantity is not available in stock .. The quantity available for order now is:")}} <span class="available-quantity"></span>
        </div>
      </div>
    </div>
  </div>



@endsection



@push('scripts-front')

<script>

$('#add-order-form-btn').on('click' , function(){


$("#cartform").submit();

$("#add-order-form-btn").attr("disabled", true);

});


</script>

@endpush
