@extends('layouts.app')

@section('content')

<!-- <h2>Admin Dashboard</h2> -->
<!-- <hr> -->

<h3>Generate Short URL</h3>


<form method="POST" action="{{ route('urls.store') }}">
    @csrf

    <input
        type="url"
        name="original_url"
        placeholder="https://example.com"
        required
    >

    <button type="submit">
        Generate
    </button>
</form>

<br><br>
<hr>


<h3>Generated Short URLs <a href="{{ route('urls.download') }}" style="margin-left: 50px;">Download</a></h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Short URL</th>
        <th>Long URL</th>
        <th>Hits</th>
        <th>User</th>
        <th>Created On</th>
    </tr>

    @forelse($urls as $url)
        <tr>
            <td>
                <a href="{{ route('urls.redirect', $url->short_code) }}" target="_blank">
                    {{ url('/s/'.$url->short_code) }}
                </a>
            </td>

            <td>{{ $url->original_url }}</td>

            <td>{{ $url->hits }}</td>
            <td>{{ $url->user_name }}</td>
            <td>{{ $url->created_at->format('Y-m-d H:i:s') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No URLs Found</td>
        </tr>
    @endforelse
</table>

<br><br><br>

<hr><h3>Team Members <a href="{{ route('member.create') }}" style="margin-left: 50px;">Invite</a></h3>

<hr><br>

<table border="1" cellpadding="10">

<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Total Generated URLs</th>
    <th>Total Hits</th>
</tr>

@forelse($members as $member)

<tr>
    <td>{{ $member->name }}</td>
    <td>{{ $member->email }}</td>
    <td>{{ ucfirst($member->role) }}</td>
    <td>{{ $member->total_urls }}</td>
    <td>{{ $member->total_hits }}</td>
</tr>

@empty

<tr>
    <td colspan="3">
        No Members Found
    </td>
</tr>

@endforelse

</table>

@endsection