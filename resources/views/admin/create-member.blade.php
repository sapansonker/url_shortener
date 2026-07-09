@extends('layouts.app')

@section('content')

<h2>Create Member</h2>

<form method="POST" action="{{ route('member.store') }}">

    @csrf

    <p>
        Name<br>
        <input type="text" name="name">
    </p>

    <p>
        Email<br>
        <input type="email" name="email">
    </p>

    <p>
        User Type<br>

        <select name="role">
            <option value="member">Member</option>
            <option value="admin">Admin</option>
        </select>
    </p>

    <p>
        Password<br>
        <input type="password" name="password">
    </p>

    <button type="submit">
        Create Member
    </button>

</form>

@endsection