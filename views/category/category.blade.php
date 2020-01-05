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
        <a href="/categories/create" class="button">Add Category</a>
        <table id="categoryDT" class="display">
            <thead>
                <tr>
                    <th><a >Id</a></th>
                    <th><a>Name</a></th>
                    <th><a>Briefing</a></th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
{{--            <tbody>--}}
{{--                @foreach ($categories as $category)--}}
{{--                    <tr>--}}
{{--                        <td>{{$category['id']}}</td>--}}
{{--                        <td>{{$category['name']}}</td>--}}
{{--                        <td>{{$category['briefing']}}</td>--}}
{{--                        <td class="editRow">Edit</td>--}}
{{--                        <td class="deleteRow">Delete</td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--            </tbody>--}}
        </table>
        <p class="successMessage"></p>
    </div>

@endsection

@section("additional-scripts")
    <script src="{{scriptUrl('dataTables.js')}}"></script>
@endsection

{{--@section('additional-scripts')--}}
{{--    <script src="{{scriptUrl('dataTables.js')}}"></script>--}}
{{--@endsection--}}