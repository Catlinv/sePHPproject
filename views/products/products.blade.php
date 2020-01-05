@extends('layout.main')

@section('content')
{{--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">--}}
{{--    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>--}}

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
        <a href="/products/create" class="button">Add Product</a>
        <a href="/products/export" class="button">Export Products</a>
        <a href="/products/template" class="button">Product import template</a>
        <table id="productsDT" class="display">
            <thead>
                <tr>
                    <th><a >Id</a></th>
                    <th><a>Name</a></th>
                    <th><a>Units</a></th>
                    <th><a>Price</a></th>
                    <th><a>Description</a></th>
                    <th><a>Category Id</a></th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
        </table>
        <p class="successMessage"></p>
        <form action="/products/import" method="post" enctype="multipart/form-data">
            Select csv file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload CSV" name="submit">
        </form>
        @if (isset($error['invalidFile']))
            <p class="errorText">INVALID FILE</p>
        @endif
    </div>

@endsection

@section("additional-scripts")
    <script src="{{scriptUrl('dataTables.js')}}"></script>
@endsection

{{--@section('additional-scripts')--}}
{{--    <script src="{{scriptUrl('dataTables.js')}}"></script>--}}
{{--@endsection--}}