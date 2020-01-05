@extends('layout.main')

@section("content")

    <div class="content">

        <form action="/products/{{$product['id']}}/update" method="post" id="loginForm">
            <p class="tansparentLabel">
                NAME
                @if (isset($error['name']))
                    <span class="errorText">FIELD IS REQUIRED</span>
                @endif
            </p>
            <input type="text" name="name" value="{{$product['name']}}">
            <br>
            <p class="tansparentLabel">
                UNITS
                @if (isset($error['units']))
                    <span class="errorText"> FIELD IS REQUIRED </span>
                @endif
            </p>
            <input type="text" name="units" value="{{$product['units']}}">
            <p class="tansparentLabel">
                PRICE
                @if (isset($error['price']))
                    <span class="errorText"> FIELD IS REQUIRED </span>
                @endif
            </p>
            <input type="text" name="price" value="{{$product['price']}}">
            <p class="tansparentLabel">
                DESCRITION
                @if (isset($error['description']))
                    <span class="errorText"> FIELD IS REQUIRED </span>
                @endif
            </p>
            <input type="text" name="description" value="{{$product['description']}}">
            <p>
            <select name="categoryId">
                @foreach ($categories as $category)
                    @if($category['id'] == $product['category_id'])
                        <option value="{{$category['id']}}" selected="selected">{{$category['name']}}</option>
                    @else
                        <option value="{{$category['id']}}">{{$category['name']}}</option>
                    @endif
                @endforeach
            </select>
            </p>
            <input type="hidden" name="id" value="{{$product['id']}}">
            <button>Update Product</button>
        </form>
        @if  (isset($error['connection']))
            <span class="errorText">CANNOT CONNECT TO DATABASE</span>
        @endif

    </div>
@endsection