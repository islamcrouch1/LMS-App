<table class="table mb-0 thead-border-top-0 table-nowrap">
    <thead>
        <tr>
            <th>

            </th>
            <th>
                {{__('Product')}}
            </th>
            <th>
                {{__('Quantity')}}
            </th>
            <th>
                {{__('Price')}}
            </th>
        </tr>
    </thead>
    <tbody class="list order-list">

        @foreach ($products as $product)
        <tr>
            <td style="width:20%; text-align:center;"><img style="width:30%" alt="Avatar" class="table-avatar" src="{{ asset('storage/images/products/' . $product->image) }}"></td>
            <td>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</td>
            <td>{{ $product->pivot->quantity }}</td>
            <td>{{ number_format($product->pivot->quantity * $product->sale_price, 2) }}</td>

        </tr>
        @endforeach

    </tbody>
</table>


<div class="products-div">
    <h4 style="padding:10px; padding-bottom:0px">{{__('Total : ')}}<span class="total-price">
        {{ number_format($order->total_price, 2) }}
    </span></h4>

    @php
    $address =  $order->address;
    @endphp

    <h6 style="padding:10px">{{__('Order Address')}}</h6>
    <p style="font-size:15px; padding:5px;">
        {{ app()->getLocale() == 'ar' ? $user->country->name_ar : $user->country->name_en}} {{'-' .  $address->province . '-' . $address->city . '-' . $address->district . '-' . $address->street . '-' . $address->building . '-' . $address->phone . '-' . $address->notes . '-' }}
    </p>
</div>


