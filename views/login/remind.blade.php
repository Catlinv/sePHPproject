@extends('layout.main')

@section("content")

    <div class="content">

        <form action="/remindUser" method="post" id="loginForm">
            <p class="tansparentLabel">
                EMAIL
                @if (isset($error['emailAddress']))
                    <span class="errorText">FIELD IS REQUIRED</span>
                @elseif (isset($error['emailAddressFormat']))
                    <span class="errorText">EMAIL IS INVALID</span>
                @endif
            </p>
            <input type="text" name="emailAddress">
            <button>Send reset Link</button>
        </form>
        @if  (isset($error['connection']))
            <span class="errorText">CANNOT CONNECT TO DATABASE</span>
        @elseif(isset($error['unknownUser']))
            <span class="errorText">USER NOT IN DATABASE</span>
        @endif

    </div>
@endsection