@extends('layout.main')

@section("content")

    <div class="content">

        <form action="/products" method="post" id="loginForm">
            <p class="tansparentLabel">
                NAME
                @if (isset($error['name']))
                    <span class="errorText">FIELD IS REQUIRED</span>
                @endif
            </p>
            <input type="text" name="name">
            <br>
            <p class="tansparentLabel">
                UNITS
                @if (isset($error['units']))
                    <span class="errorText"> FIELD IS REQUIRED </span>
                @endif
            </p>
            <input type="text" name="units">
            <p class="tansparentLabel">
                PRICE
                @if (isset($error['price']))
                    <span class="errorText"> FIELD IS REQUIRED </span>
                @endif
            </p>
            <input type="text" name="price">
            <p class="tansparentLabel">
                DESCRITION
                @if (isset($error['description']))
                    <span class="errorText"> FIELD IS REQUIRED </span>
                @endif
            </p>
            <input type="text" name="description">
            <select name="categoryId">
                @foreach ($categories as $category)
                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                @endforeach
            </select>
            <button>Create New Product</button>
        </form>
        @if  (isset($error['connection']))
            <span class="errorText">CANNOT CONNECT TO DATABASE</span>
        @endif

    </div>
@endsection