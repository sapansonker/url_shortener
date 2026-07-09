@extends('layouts.app')

@section('content')

<h2>Member Dashboard</h2>

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

<hr>

<h3>My URLs</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Short URL</th>
        <th>Original URL</th>
        <th>Hits</th>
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
        </tr>
    @empty
        <tr>
            <td colspan="3">No URLs Found</td>
        </tr>
    @endforelse
</table>

@endsection