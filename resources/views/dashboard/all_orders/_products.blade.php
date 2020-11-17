<div id="print-area">
    <table class="table table-striped projects">

        <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->name_en }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ number_format($product->pivot->quantity * $product->sale_price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h3  style="padding:10px">total price <span>{{ number_format($order->total_price, 2) }}</span></h3>

    <div class="card">
        <h5  style="padding:10px" class="card-title">Order status</h5>
        <div class="card-body">
            @switch($order->status)
            @case('recieved')
            {{__('Awaiting review from management')}}
                @break
            @case("processing")
            {{__('Your order is under review')}}
            @break
            @case("shipped")
            {{__('Your order has been shipped')}}
            @break
            @case("completed")
            {{__('You have successfully received your request')}}
            @break
            @default
        @endswitch
        </div>
    </div>

    <div class="card">
        <h5  style="padding:10px" class="card-title">Order Address</h5>
        <div class="card-body">
            @php
               $address =  $order->address;
            @endphp
            {{$user->country->name_en . '-' .  $address->province . '-' . $address->city . '-' . $address->district . '-' . $address->street . '-' . $address->building . '-' . $address->phone . '-' . $address->notes . '-' }}
        </div>
    </div>

</div>




<button class="btn btn-block btn-primary print-btn"><i class="fa fa-print"></i>Print</button>
