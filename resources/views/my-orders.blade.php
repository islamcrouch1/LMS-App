@extends('layouts.front.app')



@section('content')


<div style="" class="page-section">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Library Orders') }}</div>
        </div>

        @if ($user->orders->count() == 0 || $user->orders->where('payment_status' , 'done')->count() == 0)
        <div style="padding:20px" class="row">
            <div class="col-md-6 pt-3">
                <h6>{{__('No orders in your account ..! Go to the library enjoy many great products')}}</h6>
            </div>
            <div class="col-md-6">
                <a href="{{route('library' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id])}}" type="button" class="btn btn-outline-primary">{{__('Library')}}</a>
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
                            <th>
                                {{__('Action')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list order-list">

                        @foreach ($user->orders->reverse() as $order)
                        @if ($order->payment_status == 'done')
                        <tr>
                            <td style="">{{$order->id}}</td>
                            <td style="">{{$order->total_price}} {{' ' . $user->country->currency}}</td>
                            <td style="">{{$order->created_at}}</td>
                            <td style="">

                                @switch($order->status)
                                @case('recieved')
                                <span class="badge badge-success badge-lg">{{__('Awaiting review from management')}}</span>
                                    @break
                                @case("processing")
                                <span class="badge badge-warning badge-lg">{{__('Your order is under review')}}</span>
                                @break
                                @case("shipped")
                                <span class="badge badge-info badge-lg">{{__('Your order has been shipped')}}</span>
                                @break
                                @case("completed")
                                <span class="badge badge-primary badge-lg">{{__('You have successfully received your request')}}</span>
                                @break
                                @default
                                @endswitch


                            </td>



                            <td>

                                <a style="color:#fff;" class="btn btn-primary btn-sm order-products"
                                data-url="{{ route('my-orders.products',['lang'=>app()->getLocale() , 'order'=>$order->id , 'country'=>$scountry->id , 'user'=>auth::id()] ) }}"
                                data-method="get"
                                data-loader="loader-{{$order->id}}"
                                >
                                    <i class="fa fa-list"></i>
                                    {{__('Show Products')}}

                                    <div id="loader-{{$order->id}}" style="display:none" class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
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

@if ($user->type == 'student')


<div style="" class="page-section">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('My Homework Orders') }}</div>
        </div>

        @php
            $homeWorkCount = 0 ;
        @endphp

        @foreach ($user->home_work_orders->reverse() as $homeworkOrder)
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
                                {{__('Order No')}}
                            </th>
                            <th>
                                {{__('Total')}}
                            </th>
                            <th>
                                {{__('Course')}}
                            </th>
                            <th>
                                {{__('Order Date')}}
                            </th>
                            <th>
                                {{__('Order status')}}
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
                            <td style="">{{$homeworkOrder->id}}</td>
                            <td style="">{{$homeworkOrder->total_price}} {{' ' . $user->country->currency}}</td>
                            <td style="">{{ app()->getLocale() == 'ar' ? $homeworkOrder->course->name_ar : $homeworkOrder->course->name_en}}</td>
                            <td style="">{{$homeworkOrder->created_at}}</td>
                            <td style=""><span class="badge badge-success badge-lg"> {{__('Payment is accepted')}} <span></td>




                            <td>

                                <a href="{{route('homework' , ['lang'=>app()->getLocale() , 'user'=>$user->id ,  'country'=>$scountry->id])}}" style="color:#fff;" class="btn btn-primary btn-sm">
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




    </div>
</div>

@endif



<div style="" class="page-section">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Courses Orders') }}</div>
        </div>

        @php
            $CoursesCount = 0 ;
        @endphp

        @foreach ($user->course_orders->reverse() as $courseOrder)
        @if ($courseOrder->status == 'done')
            @php
                $CoursesCount = $CoursesCount + 1 ;
            @endphp
        @endif
        @endforeach

        @if ($user->course_orders->count() == 0 || $CoursesCount == 0)

        <div style="padding:20px" class="row">
            <div class="col-md-6 pt-3">
                <h6>{{__('No orders in your account ..! Go to the Home page and choose your course to help you with your study')}}</h6>
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
                                {{__('Course')}}
                            </th>
                            <th>
                                {{__('Order Date')}}
                            </th>
                            <th>
                                {{__('Order status')}}
                            </th>
                            <th>
                                {{__('Action')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list order-list">

                        @foreach ($user->course_orders->reverse() as $courseOrder)
                        @if ($courseOrder->status == 'done')
                        <tr>
                            <td style="">{{$courseOrder->id}}</td>
                            <td style="">{{$courseOrder->total_price}} {{' ' . $user->country->currency}}</td>
                            <td style="">{{ app()->getLocale() == 'ar' ? $courseOrder->course->name_ar : $courseOrder->course->name_en}}</td>
                            <td style="">{{$courseOrder->created_at}}</td>
                            <td style=""><span class="badge badge-success badge-lg"> {{__('Payment is accepted')}} <span></td>




                            <td>

                                <a href="{{route('courses' , ['lang'=>app()->getLocale() , 'course'=>$courseOrder->course->id , 'country'=>$scountry->id])}}" style="color:#fff;" class="btn btn-primary btn-sm">
                                    <i class="fa fa-video"></i>
                                    {{__('Watch Course')}}

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




<div style="" class="page-section">
    <div class="container page__container">
        <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Downloadable products') }}</div>
        </div>

        @php
            $pcount = 0;
        @endphp

        @foreach ($user->orders->reverse() as $order)

            @foreach ($order->products->reverse() as $product)

            @if ($product->type == 'downloaded_product')

            @php
                $pcount = $pcount + 1 ;
            @endphp

            @endif
            @endforeach

        @endforeach

        @if ( $pcount == 0)
        <div style="padding:20px" class="row">
            <div class="col-md-6 pt-3">
                <h6>{{__('No Downloadable products ..! Go to the library enjoy many great products')}}</h6>
            </div>
            <div class="col-md-6">
                <a href="{{route('library' , ['lang'=>app()->getLocale() ,  'country'=>$scountry->id])}}" type="button" class="btn btn-outline-primary">{{__('Library')}}</a>
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
                                {{__('Product')}}
                            </th>
                            <th>
                                {{__('Action')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list order-list">


                        @foreach ($user->orders->reverse() as $order)

                        @foreach ($order->products->reverse() as $product)

                        @if ($product->type == 'downloaded_product')

                        <tr>
                            <td style="width:20%; text-align:center;"><img style="width:30%" alt="Avatar" class="table-avatar" src="{{ asset('storage/images/products/' . $product->image) }}"></td>
                            <td>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</td>


                            <td>

                                <a href="{{ asset('storage/products/files/' . $product->down_link) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-download"></i>
                                    {{__('Download')}}

                                </a>

                            </td>
                        </tr>

                        @endif
                        @endforeach

                        @endforeach





                    </tbody>
                </table>
            </div>

        </div>
    @endif




    </div>
</div>


@foreach ($user->orders as $order)


<div style="" class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Order No : ')}} {{$order->id}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <div class="card mb-lg-32pt">

            <div class="table-responsive">



                <div id="order-product-list">





                </div><!-- end of order product list -->






            </div>

        </div>



      </div>
    </div>
</div>

@endforeach

@endsection
