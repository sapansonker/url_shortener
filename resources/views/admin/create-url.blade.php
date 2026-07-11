@extends('layouts.app')

@section('content')

<style>
    .create-url-container {
        max-width: 680px;
        margin: 0 auto;
        padding: 2rem;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    }

    .create-url-header {
        margin-bottom: 1.5rem;
    }

    .create-url-heading {
        font-size: 1.9rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .create-url-description {
        margin-top: 0.75rem;
        color: #4b5563;
        font-size: 0.95rem;
    }

    .create-url-form {
        display: grid;
        gap: 1rem;
    }

    .create-url-input,
    .create-url-button,
    .create-url-back {
        width: 90%;
        border-radius: 0.75rem;
        font-weight: 600;
    }

    .create-url-input {
        padding: 1rem 1.1rem;
        border: 1px solid #d1d5db;
        font-size: 1rem;
    }

    .create-url-button {
        padding: 0.95rem 1.1rem;
        border: none;
        background: #2563eb;
        color: white;
        cursor: pointer;
    }

    .create-url-button:hover {
        background: #1d4ed8;
    }

    .create-url-back {
        display: inline-flex;
        justify-content: center;
        padding: 0.95rem 1.1rem;
        background: #f8fafc;
        border: 1px solid #d1d5db;
        color: #111827;
        text-decoration: none;
    }

    .create-url-back:hover {
        background: #eef2ff;
    }
</style>

<div class="create-url-container">
    <div class="create-url-header">
        <h3 class="create-url-heading">Generate Short URL</h3>
        <p class="create-url-description">Enter a long URL to generate a short link, then return to the dashboard.</p>
    </div>

    <form class="create-url-form" method="POST" action="{{ route('urls.store') }}">
        @csrf

        <input
            class="create-url-input"
            type="url"
            name="original_url"
            placeholder="https://example.com"
            required
        >

        <button class="create-url-button" type="submit">Generate</button>

        <a class="create-url-back" href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
    </form>
</div>

@endsection