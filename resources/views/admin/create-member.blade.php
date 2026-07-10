@extends('layouts.app')

@section('content')

<style>
    .member-form-page {
        display: flex;
        justify-content: center;
        padding: 1rem;
        background: #f8fafc;
        min-height: 70vh;
    }

    .member-form-card {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        padding: 1.75rem;
    }

    .member-form-card h2 {
        margin: 0 0 0.75rem;
        font-size: 1.7rem;
        color: #111827;
        font-weight: 700;
    }

    .member-form-card p {
        margin-bottom: 0.85rem;
    }

    .member-form-card label {
        display: block;
        margin-bottom: 0.35rem;
        font-weight: 600;
        color: #111827;
        font-size: 0.95rem;
    }

    .member-form-card input,
    .member-form-card select {
        width: 90%;
        padding: 0.9rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
        font-size: 0.98rem;
        color: #111827;
        background: #ffffff;
    }

    .member-form-card input:focus,
    .member-form-card select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .member-form-actions {
        display: grid;
        gap: 0.75rem;
        margin-top: 1.25rem;
    }

    .member-form-button,
    .member-form-back {
        width: 100%;
        padding: 0.95rem 1rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }

    .member-form-button {
        background: #2563eb;
        color: #ffffff;
        border: 1px solid #2563eb;
    }

    .member-form-button:hover {
        background: #1d4ed8;
    }

    .member-form-back {
        background: #f8fafc;
        color: #111827;
        border: 1px solid #d1d5db;
    }

    .member-form-back:hover {
        background: #eef2ff;
    }
</style>

<div class="member-form-page">
    <div class="member-form-card">
        <h2>Create Member</h2>

        <form method="POST" action="{{ route('member.store') }}">
            @csrf

            <p>
                <label for="name">Name</label>
                <input id="name" type="text" name="name" required>
            </p>

            <p>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" required>
            </p>

            <p>
                <label for="role">User Type</label>
                <select id="role" name="role">
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                </select>
            </p>

            <p>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </p>

            <div class="member-form-actions">
                <button class="member-form-button" type="submit">Create Member</button>
                <button class="member-form-back" type="button" onclick="window.location.href='{{ route('admin.dashboard') }}'">Back to Dashboard</button>
                <!-- <a class="member-form-back" href="{{ route('admin.dashboard') }}">Back to Dashboard</a> -->
            </div>
        </form>
    </div>
</div>

@endsection