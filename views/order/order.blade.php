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
        <table id="ordersDT" class="display">
            <thead>
            <tr>
                <th><a>Id</a></th>
                <th><a>User Id</a></th>
                <th><a>Order Date</a></th>
                <th><a>Total price</a></th>
                <th>Delete</th>
            </tr>
            </thead>
        </table>
        <p class="successMessage"></p>
    </div>

@endsection

@section("additional-scripts")
    <script src="{{scriptUrl('dataTables.js')}}"></script>
@endsection
