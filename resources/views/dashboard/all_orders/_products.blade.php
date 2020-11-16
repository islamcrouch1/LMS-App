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
    <h3>total price <span>{{ number_format($order->total_price, 2) }}</span></h3>


    <div class="card">
        <h5 class="card-title">Order Address</h5>
        <div class="card-body">
            @php
               $address =  $order->address
            @endphp
            {{$address->country->name . '-' .  $address->province . '-' . $address->city . '-' . $address->district . '-' . $address->street . '-' . $address->building . '-' . $address->phone . '-' . $address->notes . '-' }}
        </div>
    </div>

</div>




<button class="btn btn-block btn-primary print-btn"><i class="fa fa-print"></i>Print</button>
