<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body>

<h2>URL Shortener</h2>
<hr>

@if(auth()->check())

    Logged in as:
    <strong>{{ auth()->user()->name }}</strong>

    ({{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }})

    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" style="float:right;">Logout</button>
    </form>

    <hr>

@endif

@if(session('success'))
    <p style="color:green">
        {{ session('success') }}
    </p>
@endif

@yield('content')

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>