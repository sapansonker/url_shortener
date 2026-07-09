@extends('layouts.app')

@section('content')

<h2>Generate Short URL</h2>

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

<table border="1" cellpadding="10">

<tr>

    <th>Short URL</th>

    <th>Original URL</th>

    <th>Hits</th>

</tr>

@forelse($urls as $url)

<tr>

<td>
    {{ url('/s/'.$url->short_code) }}
</td>

<td>
    {{ $url->original_url }}
</td>

<td>
    {{ $url->hits }}
</td>

</tr>

@empty

<tr>

<td colspan="3">
No URLs Found
</td>

</tr>

@endforelse

</table>

@endsection