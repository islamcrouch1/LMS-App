@extends('layouts.front.app')



@section('content')

<div class="container page__container">


        <div class="row pt-5">

            <div class="col-md-4">
                <h3>{{ __('Library') }}</h3>
            </div>
            <div class="col-md-8">
                    <input class="form-control" type="text" placeholder="{{__('Search for products')}}" aria-label="{{__('Search for products')}}">
            </div>
        </div>



    <div class="page-separator pt-1 pb-1">
        <div class="page-separator__text">{{ __('Products Categories') }}</div>
    </div>


    <div class="row card-group-row" >



        @foreach ($categories as $category)

            <div class="col-md-6 col-lg-4 card-group-row__col">


                <div class="card card--elevated posts-card-popular overlay card-group-row__card">
                    <img src="{{ asset('storage/images/categories/' . $category->image) }}"
                        alt="{{ app()->getLocale() == 'ar' ? $category->description_ar : $category->description_en}}"
                        class="card-img">
                    <div class="fullbleed bg-primary"
                        style="opacity: .3"></div>
                    <div class="posts-card-popular__content" style="z-index: 1000000001 !important">
                        <div class="card-body d-flex align-items-center" >
                            <a style="text-decoration: none;"
                            class="d-flex align-items-center"
                            href="#"><i class="material-icons mr-1"
                                style="font-size: inherit;">view_list</i> <small>{{ $category->products->count() }}</small></a>
                        </div>
                        <div class="posts-card-popular__title card-body">
                            <a class="card-title category-products"
                            href="{{ route('library.products', [ 'lang'=>app()->getLocale() , 'category'=>$category->id , 'country'=>$scountry->id ] ) }}"
                            >{{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en}}</a>
                        </div>
                    </div>
                </div>


            </div>
        @endforeach

    </div>



</div>

{{-- <div style="display: none; flex-direction: column; align-items: center;" id="loading">
    <div class="loaderr"></div>
    <p style="margin-top: 10px">{{__("Loading ....")}}</p>
</div> --}}

<div  id="category-product-list">


    <div class="page-section border-bottom-2">
        <div class="container page__container">
            <div class="page-separator pt-1 pb-1">
                <div class="page-separator__text">{{ __('Products') }}</div>
            </div>




                <div class="row card-group-row">

                    @foreach ($products as $product)
                    <div class="col-md-3 col-sm-6">
                        <div class="product-grid4">
                            <div class="product-image4">
                                <a href="#">
                                    <img class="pic-1" src="{{ asset('storage/images/products/' . $product->image) }}">
                                    <img class="pic-2" src="{{ asset('storage/images/products/' . $product->image) }}">
                                </a>
                                <ul class="social">
                                    <li><a  href="#" class="viewbtn" data-toggle="popover" data-trigger="click" title="{{__('Product Description')}}" data-content="{{ app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en}}" data-tip="{{__('Quick View')}}"><i class="fa fa-eye"></i></a></li>
                                    {{-- <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li> --}}

                                    <li><a
                                        data-url="aaaaaaaaaaaaa"
                                        data-check="{{Auth::check() ? $check = 'true' : $check = 'false'}}"
                                        data-method="get"
                                        href="#" class="add-cart" data-tip="{{__('Add to cart')}}"><i class="fa fa-shopping-cart"></i>
                                        <div style="display:none" class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                          </div>
                                        </a>

                                    </li>
                                </ul>
                                {{-- <span class="product-new-label">New</span>
                                <span class="product-discount-label">-10%</span> --}}
                            </div>
                            <div class="product-content" id="content-{{$product->id}}">
                            @if (Auth::check())
                            @php
                                $ssproduct = "non";
                            @endphp
                                @foreach (Auth::user()->cart->products as $sproduct)
                                    @if ($sproduct->id == $product->id)
                                    @php
                                    $ssproduct = $sproduct->id;
                                    @endphp
                                    <h3 class="title"><a href="#" class="viewbtn" data-toggle="popover" data-trigger="click" title="{{__('Product Description')}}" data-content="{{ app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en}}" data-tip="{{__('Quick View')}}">
                                        {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</a></h3>
                                    <div class="price">
                                        <p class="flex text-50 lh-1 mb-0"><small>{{__('Price')}} {{ ' : ' . $product->sale_price}}</small></p>
                                        <p class="flex text-50 lh-1 mb-0"><small>{{__('Stock')}} {{ ' : ' . $product->stock}}</small></p>
                                    </div>
                                    <a id="cart-{{$product->id}}" class="add-to-cart" href="{{ route('cart',['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'country'=>$scountry->id ] ) }}">
                                        {{__('Show Cart')}}
                                    </a>
                                    @endif
                                @endforeach
                                    @if (  $ssproduct == "non" )
                                    <h3 class="title"><a href="#" class="viewbtn" data-toggle="popover" data-trigger="click" title="{{__('Product Description')}}" data-content="{{ app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en}}" data-tip="{{__('Quick View')}}">
                                        {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</a></h3>
                                    <div class="price">
                                        <p class="flex text-50 lh-1 mb-0"><small>{{__('Price')}} {{ ' : ' . $product->sale_price}}</small></p>
                                        <p class="flex text-50 lh-1 mb-0"><small>{{__('Stock')}} {{ ' : ' . $product->stock}}</small></p>
                                    </div>
                                    <a id="cart-{{$product->id}}" class="add-to-cart add-cart" href="#"
                                            @if (Auth::check())
                                            data-url="{{ route('cart.add',['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'product'=>$product->id , 'country'=>$scountry->id ] ) }}"
                                            @endif
                                            data-check="{{Auth::check() ? $check = 'true' : $check = 'false'}}"
                                            data-method="get"
                                            data-product="loader-{{$product->id}}"
                                            data-cart="cart-{{$product->id}}"
                                            data-productid="{{$product->id}}"
                                    >{{__('Add to cart')}}
                                        <div id="loader-{{$product->id}}" style="display:none" class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </a>
                                    @endif
                            @else
                                        <h3 class="title"><a href="#" class="viewbtn" data-toggle="popover" data-trigger="click" title="{{__('Product Description')}}" data-content="{{ app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en}}" data-tip="{{__('Quick View')}}">
                                            {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</a></h3>
                                        <div class="price">
                                            <p class="flex text-50 lh-1 mb-0"><small>{{__('Price')}} {{ ' : ' . $product->sale_price}}</small></p>
                                            <p class="flex text-50 lh-1 mb-0"><small>{{__('Stock')}} {{ ' : ' . $product->stock}}</small></p>
                                        </div>
                                        <a id="cart-{{$product->id}}" class="add-to-cart add-cart" href="#"
                                                @if (Auth::check())
                                                data-url="{{ route('cart.add',['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'product'=>$product->id , 'country'=>$scountry->id  ] ) }}"
                                                @endif
                                                data-check="{{Auth::check() ? $check = 'true' : $check = 'false'}}"
                                                data-method="get"
                                                data-product="loader-{{$product->id}}"
                                                data-cart="cart-{{$product->id}}"
                                                data-productid="{{$product->id}}"
                                        >{{__('Add to cart')}}
                                            <div id="loader-{{$product->id}}" style="display:none" class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </a>
                                    @endif

                            </div>
                        </div>
                    </div>
                    @endforeach



                </div>

                <div class="row mt-3"> {{ $products->appends(request()->query())->links() }}</div>
        </div>
    </div>

</div>



<!-- Button trigger modal -->


  <!-- Modal -->
  <div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{__("Please login to add products to cart, if you don't have account please register one now ....")}}
        </div>
        <div class="modal-footer">
        <a href="{{ route('login' , app()->getLocale()) }}" class="btn btn-primary">{{__("Login")}}</a>
          <a href="{{ route('register' , app()->getLocale()) }}" class="btn btn-success">{{__("Register")}}</a>
        </div>
      </div>
    </div>
  </div>

@endsection
