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

{{--        <table>--}}
{{--            <tr>--}}
{{--                <th><a href="/home?sort=id">Id</a></th>--}}
{{--                <th><a href="/home?sort=name">Name</a></th>--}}
{{--                <th><a>Description</a></th>--}}
{{--                <th><a href="/home?sort=price">Price</a></th>--}}
{{--                <th><a href="/home?sort=units">Units</a></th>--}}
{{--            </tr>--}}
{{--            @foreach ($products as $product)--}}
{{--                <tr>--}}
{{--                    <td>{{$product['id']}}</td>--}}
{{--                    <td>{{$product['name']}}</td>--}}
{{--                    <td>{{$product['description']}}</td>--}}
{{--                    <td>{{$product['price'] . " RON"}}</td>--}}
{{--                    <td class="units">{{$product['units']}}</td>--}}
{{--                    <td class="button" onclick="addProductToCart({{json_encode($product)}})"><a>Add to cart</a></td>--}}
{{--                    --}}{{--                <td><img src="http://lorempixel.com/400/200?lock={{$product['id']}}"></td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        </table>--}}
        <p class="successMessage"></p>
        <ul class="emagList">
            @foreach ($products as $product)
                <li class="emagListItem">
                    <p><img src="http://lorempixel.com/400/200?lock={{$product['id']}}" onclick="showProductDetails({{json_encode($product)}})"></p>
                    <p>{{$product['name']}}</p>
                    <p>{{$product['price'] . " RON"}}</p>
                    @if ($product['units'] > 0)
                        <p class="button" onclick="addProductToCart({{json_encode($product)}})"><a>Add to cart</a></p>
                        @else
                        <p class="errorText">Out of stock</p>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection
