@extends('layout.main')

@section("content")

    <div class="content">

        <form action="/categories/{{$id}}/update" method="post" id="loginForm">
            <p class="tansparentLabel">
                NAME
                @if (isset($error['name']))
                    <span class="errorText">FIELD IS REQUIRED</span>
                @endif
            </p>
            <input type="text" name="name" value="{{$name}}">
            <br>
            <p class="tansparentLabel">
                BRIEFING
                @if (isset($error['briefing']))
                    <span class="errorText"> FIELD IS REQUIRED </span>
                @endif
            </p>
            <input type="text" name="briefing" value="{{$briefing}}">
            <input type="hidden" name="id" value={{$id}}>
            <button>Update Category</button>
        </form>
        @if  (isset($error['connection']))
            <span class="errorText">CANNOT CONNECT TO DATABASE</span>
        @endif

    </div>
@endsection