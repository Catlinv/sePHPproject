@extends('layout.main')

@section("content")

    <div class="content">

        <form action="/resetUser" method="post" id="loginForm">
            <p class="tansparentLabel">
                NEW PASSWORD
                @if (isset($error['password1']))
                    <span class="errorText">FIELD IS REQUIRED</span>
                @elseif (isset($error['passwordMatch']))
                    <span class="errorText">PASSWORDS MUST MATCH</span>
                @endif
            </p>
            <input type="password" name="password1">
            <br>
            <p class="tansparentLabel">
                CONFIRM PASSWORD
                @if (isset($error['password2']))
                    <span class="errorText"> FIELD IS REQUIRED </span>
                @endif
            </p>
            <input type="password" name="password2">
            @if (isset($resetToken))
                <input type="hidden" value="{{$resetToken}}" name="resetToken">
            @endif
            <button>Reset Password</button>
        </form>
        @if  (isset($error['connection']))
            <span class="errorText">CANNOT CONNECT TO DATABASE</span>
        @elseif  (isset($error['invalidToken']))
            <span class="errorText">INVALID RESET TOKEN</span>
        @endif

    </div>
@endsection