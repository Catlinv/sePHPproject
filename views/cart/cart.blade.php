@extends('layout.main')

@section('content')
    <div class="content">
        <p>
            @if (isset($userData) && count($userData) > 0)
                <b>UserName: </b> {{$userData['email']}}
                &emsp;
                <b>First Name: </b> {{$userData['firstName']}}
                &emsp;
                <b>Last Name: </b> {{$userData['lastName']}}
            @endif
            @if (isset($error['login']))
                <span class="errorText">PLEASE LOGIN OR REGISTER TO PLACE AN ORDER</span>
            @endif
            &emsp;
            <b>Last Login: </b> {{(isset($_COOKIE["sessionTime"])) ? $_COOKIE["sessionTime"] : "Unknown"}}
        </p>

        <table>
            <tr>
                <th><a href="/cart?sort=id">Id</a></th>
                <th><a href="/cart?sort=name">Name</a></th>
                <th><a>Description</a></th>
                <th><a href="/cart?sort=price">Price</a></th>
                <th><a href="/cart?sort=units">Units</a></th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{$product['id']}}</td>
                    <td>{{$product['name']}}</td>
                    <td>{{$product['description']}}</td>
                    <td>{{$product['price'] . " RON"}}</td>
                    <td class="units">{{$product['units']}}</td>
                    <td class="button" onclick="changeUnits({{json_encode($product)}},1,$(this))">Increase Units</td>
                    <td class="button" onclick="changeUnits({{json_encode($product)}},-1,$(this))">Decrease Units</td>
                    <td class="button" onclick="removeProductFromCart({{json_encode($product)}},$(this))">Remove from cart</td>
                </tr>
            @endforeach
        </table>
        @if (count($products) > 0)
        <form action="/order" method="post" class="placeOrder">
            <button>Place Order</button>
        </form>
        @endif
        @if (isset($error['stock']))
            <p class="errorText"> The following items exceed our current stock</p>
            @foreach ($error['missing'] as $k => $v)
                <p class="errorText">{{$stock[$k]['name']}} - {{$v}}</p>
            @endforeach
        @endif
    </div>
@endsection
