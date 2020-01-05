@extends('layout.main')

@section('content')
    <div class="mainBody">
        <div class="orderHeader">
            <div class="companyInfo">
                <p>E-Commerce</p>
                <p>asd</p>
                <p>Random Address, Cluj-Napoca</p>
            </div>
            <div class="representativeInfo">
                <p>Ion Don</p>
                <p>ion.don@ecommerce.com</p>
                <p>0040 733 333 333</p>
            </div>
            <div class="image">
                <img src="https://as1.ftcdn.net/jpg/02/04/66/02/500_F_204660283_onveez8hTPfZlIDb9v67AUQA7kwGVX79.jpg"
                 height="150px">
            </div>
        </div>
        <p>Order</p>
        <hr>
        <div class="orderInfo">
            <div class="orderData">
                <p>Order id: {{$order['id']}}</p>
                <p>Order date: {{$order['order_date']}}</p>
                <p>Order cost: {{$order['total_price']}} RON</p>
            </div>
            <div class="clientData">
                <p style="font-weight: bold">{{$client['first_name'] . " " . $client['last_name']}}</p>
                <p>{{$client['address']}}</p>
                <p>{{$client['email']}}</p>
                <p>{{"0" . $client['phone']}}</p>
            </div>
        </div>
        <hr>
        <table class="orderItemsTable">
            <thead>
                <tr style="font-weight: bold">
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Units</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{$products[$item['product_id']]}}</td>
                        <td>{{$item['unit_price']}}</td>
                        <td>{{$item['units']}}</td>
                        <td>{{$item['total_price']}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: right;" colspan="4">Total Price: {{$order['total_price']}} RON</td>
                </tr>
            </tfoot>
        </table>
        <p class="button" onclick="downloadOrder({{$order['id']}})">Save as PDF</p>
    </div>
@endsection
