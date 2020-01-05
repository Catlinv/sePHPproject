@extends('layout.main')

@section("content")

<div class="content">

<form action="/loginUser" method="post" id="loginForm">
    <p class="tansparentLabel">
        EMAIL
        @if (isset($error['emailAddress']))
            <span class="errorText">FIELD IS REQUIRED</span>
        @elseif (isset($error['emailAddressFormat']))
            <span class="errorText">EMAIL IS INVALID</span>
        @endif
    </p>
    <input type="text" name="emailAddress">
    <br>
    <p class="tansparentLabel">
        PASSWORD
        @if (isset($error['password']))
            <span class="errorText"> FIELD IS REQUIRED </span>
        @endif
    </p>
    <input type="password" name="password">
    <p><a href="/remind">Forgot password?</a></p>
    <button>Login</button>
</form>
    @if  (isset($error['connection']))
        <span class="errorText">CANNOT CONNECT TO DATABASE</span>
    @elseif(isset($error['unknownUser']))
        <span class="errorText">USER NOT IN DATABASE</span>
    @elseif (isset($error['wrongPassword']))
        <span class="errorText">EMAIL PASSWORD COMBINATION IS INVALID</span>
    @elseif (isset($error['confirmed']))
        <span class="errorText">ACCOUNT IS NOT CONFIRMED</span>
    @endif

</div>
@endsection