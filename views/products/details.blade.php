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
                &emsp;
                <b>Last Login: </b> {{(isset($_COOKIE["sessionTime"])) ? $_COOKIE["sessionTime"] : "Unknown"}}
        </p>
        <div class="details">
            <p>
                <img src="http://lorempixel.com/400/200?lock={{$product['id']}}"> <br>
                @if ($product['units'] > 0)
                    <p class="button" onclick="addProductToCartAndSwap({{json_encode($product)}})"><a>Add to cart</a></p>
                @else
                    <p class="errorText">Out of stock</p>
                @endif
            </p>
            <p>{{$product['name']}}</p>
            <p>Stock left: {{$product['units']}}</p>
            <p>Price: {{$product['price'] . " RON"}}</p>
            <p>{{$product['description']}}</p>
        </div>
    </div>
@endsection
