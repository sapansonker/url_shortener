<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f3f4f6;
            color: #111827;
        }

        .app-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .app-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.08);
        }

        .app-brand {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .app-header-info {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            font-size: 0.95rem;
            color: #475569;
        }

        .app-header-info strong {
            color: #0f172a;
            font-weight: 700;
        }

        .app-header-button {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 0.75rem;
            padding: 0.65rem 1rem;
            cursor: pointer;
            font-weight: 600;
        }

        .app-header-button:hover {
            background: #1d4ed8;
        }

        .app-main {
            flex: 1;
            padding: 1.5rem;
            max-width: 1120px;
            margin: 0 auto;
            width: 100%;
        }

        .flash-message {
            margin: 0 0 1rem;
            padding: 1rem 1.25rem;
            border-radius: 0.85rem;
            background: #ecfdf5;
            border: 1px solid #d1fae5;
            color: #166534;
        }
    </style>
</head>
<body>
<div class="app-shell">
    <header class="app-header">
        <div class="app-brand">URL Shortener <span style="color: #801900;">(Sembark)</span></div>

        @if(auth()->check())
            <div class="app-header-info">
                <div>
                    Logged in as <strong>{{ auth()->user()->name }}</strong>
                </div>
                <div>
                    ({{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }})
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="app-header-button">Logout</button>
                </form>
            </div>
        @endif
    </header>

    <main class="app-main">
        @if(session('success'))
            <div class="flash-message">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>