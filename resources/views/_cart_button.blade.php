<h3 class="title"><a href="#" class="viewbtn" data-toggle="popover" data-trigger="click" title="{{__('Product Description')}}" data-content="{{ app()->getLocale() == 'ar' ? $product->description_ar : $product->description_en}}" data-tip="{{__('Quick View')}}">
    {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</a></h3>
<div class="price">
    <p class="flex text-50 lh-1 mb-0"><small>{{__('Price')}} {{ ' : ' . $product->sale_price  . ' ' . $product->country->currency}}</small></p>
    <p class="flex text-50 lh-1 mb-0"><small>{{__('Stock')}} {{ ' : ' . $product->stock}}</small></p>
</div>
<a id="cart-{{$product->id}}" class="add-to-cart" href="{{ route('cart',['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'country'=>$scountry->id ] ) }}">
    {{__('Show Cart')}}
</a>
