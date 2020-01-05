@extends('layout.main')

@section("content")

<div class="content">

<form action="/registerUser" method="post" enctype="multipart/form-data">
    First Name <input type="text" name="firstName">
    @if (isset($error['firstName']))
        <span class="errorText">FIELD IS REQUIRED</span>
    @endif
    <br>
    Last Name <input type="text" name="lastName">
    @if (isset($error['lastName']))
        <span class="errorText">FIELD IS REQUIRED</span>
    @endif
    <br>
    Email <input type="text" name="emailAddress">
    @if (isset($error['emailAddress']))
        <span class="errorText">FIELD IS REQUIRED</span>
    @elseif (isset($error['emailAddressFormat']))
        <span class="errorText">EMAIL IS INVALID</span>
    @endif
    <br>
    Address <input type="text" name="address">
    @if (isset($error['address']))
        <span class="errorText">FIELD IS REQUIRED</span>
    @endif
    <br>
    Phone <input type="text" name="phone">
    @if (isset($error['phone']))
        <span class="errorText">FIELD IS REQUIRED</span>
    @elseif (isset($error['phoneFormat']))
        <span class="errorText">PHONE IS INVALID</span>
    @endif
    <br>
    Password <input type="text" name="password">
    @if (isset($error['password']))
        <span class="errorText">FIELD IS REQUIRED</span>
    @endif
    <br>
    @if  (isset($error['connection']))
        <span class="errorText">CANNOT CONNECT TO DATABASE</span>
    @elseif(isset($error['alreadyUser']))
        <span class="errorText">USER ALREADY IN DATABASE</span>
    @endif
    <br>
    <button>Register</button>
</form>

</div>
@endsection