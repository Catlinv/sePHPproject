@extends('layout.main')

@section('content')

{{--    <div class="content">--}}
{{--        <div class="payBox">--}}
{{--            <input id="cardholder-name" type="text">--}}
{{--            <div id="card-element"></div>--}}
{{--            <button id="card-button" data-secret="{{$intent->client_secret}}">--}}
{{--                Submit Payment--}}
{{--            </button>--}}
{{--            <p class="errorText" hidden>An error has occurred</p>--}}
{{--        </div>--}}
{{--    </div>--}}

<form id="myForm" action="http://localhost:8080" method="post">
    <input type="hidden" name="clientId" value="{{$userData['clientId']}}">
    <input type="hidden" name="storeKey" value="{{$userData['storeKey']}}">
    <input type="hidden" name="clientKey" value="{{$userData['clientKey']}}">
    <input type="hidden" name="sum" value="{{$userData['sum']}}">
</form>

@endsection

@section("additional-scripts")
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{scriptUrl('payment.js')}}"></script>
@endsection
