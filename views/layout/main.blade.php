<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Internship</title>
        <link rel="stylesheet" href="{{styleUrl('main.css')}}">
        <link rel="shortcut icon" href="{{iconUrl()}}" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        @yield('additional-css')
    </head>
    <body>
    @include('layout.header')
    @yield('content')
    @include('layout.footer')

    <script src="{{scriptUrl('jquery-3.4.1.js')}}"></script>
    <script src="{{scriptUrl('main.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    @yield('additional-scripts')
    </body>
</html>
