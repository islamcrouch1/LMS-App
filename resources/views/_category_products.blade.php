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
                        style="opacity: .5"></div>
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



<div  id="category-product-list">


    <div class="page-section border-bottom-2">
        <div class="container page__container">
            <div class="page-separator pt-1 pb-1">
                <div class="page-separator__text">{{ __('Products') . '-' }}  {{ app()->getLocale() == 'ar' ? $scategory->name_ar : $scategory->name_en }}</div>
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
                                <li><a href="#" data-tip="{{__('Add to cart')}}"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                            {{-- <span class="product-new-label">New</span>
                            <span class="product-discount-label">-10%</span> --}}
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</a></h3>
                            <div class="price">
                                <p class="flex text-50 lh-1 mb-0"><small>{{__('Price')}} {{ ' : ' . $product->sale_price}}</small></p>
                                <p class="flex text-50 lh-1 mb-0"><small>{{__('Stock')}} {{ ' : ' . $product->stock}}</small></p>
                            </div>
                            <a class="add-to-cart" href="">{{__('Add to cart')}}</a>
                        </div>
                    </div>
                </div>
                @endforeach





            </div>

                <div class="row mt-3"> {{ $products->appends(request()->query())->links() }}</div>
        </div>
    </div>

</div>






@endsection
