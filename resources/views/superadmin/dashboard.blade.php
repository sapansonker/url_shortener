@extends('layouts.app')

@section('content')

<h3>Clients</h3>

<a href="{{ route('company.create') }}">
    <!-- Invite Client's -->
    <button type="submit">Invite Client's</button>
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <!-- <th>ID</th> -->
        <th>Client Name</th>
        <th>Users</th>
        <th>Total Generated Urls</th>
        <th>Total Url Hits</th>
    </tr>

    @foreach($companies as $company)

        <tr>
            <!-- <td>{{ $company->cid }}</td> -->
            <td>{{ $company->name }}</td>
            <td>{{ $company->total_users }}</td>
            <td>{{ $company->total_urls }}</td>
            <td>{{ $company->total_hits }}</td>
        </tr>

    @endforeach

</table>

<br><br><br>

<hr><h3>Generated Short URLs <a href="{{ route('urls.download') }}" style="margin-left: 50px;">Download</a></h3>

<hr><br>

<table border="1" cellpadding="10">

<tr>
    <th>Short URL</th>
    <th>Long URL</th>
    <th>Hits</th>
    <th>Company Name</th>
    <th>Created At</th>
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
        <td>{{ $url->company_name }}</td>
        <td>{{ $url->created_at->format('Y-m-d H:i:s') }}</td>
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