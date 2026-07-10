@extends('layouts.app')

@section('content')

<style>
    .create-company-page {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 70vh;
        padding: 1.25rem;
        background: #f8fafc;
    }

    .create-company-card {
        width: 100%;
        max-width: 520px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        padding: 1.5rem;
    }

    .create-company-card h2 { margin:0 0 0.6rem; font-size:1.6rem; color:#111827; }
    .create-company-card p { margin:0 0 0.85rem; }

    .form-label { display:block; margin-bottom:0.35rem; font-weight:600; color:#111827; }
    .form-input { width:90%; padding:0.85rem 0.9rem; border:1px solid #d1d5db; border-radius:0.75rem; font-size:0.95rem; }
    .form-input:focus { outline:none; border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.12); }

    .form-actions { display:grid; gap:0.65rem; margin-top:1rem; }
    .btn-primary { width:100%; padding:0.9rem; border-radius:0.75rem; background:#2563eb; color:#fff; border:1px solid #2563eb; font-weight:600; }
    .btn-secondary { width:100%; padding:0.9rem; border-radius:0.75rem; background:#f8fafc; color:#111827; border:1px solid #d1d5db; font-weight:600; }

    .errors { background:#fff1f2; border:1px solid #fecaca; padding:0.75rem; border-radius:0.5rem; color:#b91c1c; margin-bottom:0.75rem; }
</style>

<div class="create-company-page">
    <div class="create-company-card">
        <h2>Invite Client</h2>
        <p class="text-muted">Create a new client company and admin account.</p>

        @if($errors->any())
            <div class="errors">
                <ul style="margin:0; padding-left:1.2rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('company.store') }}" method="POST">
            @csrf

            <p>
                <label class="form-label" for="company_name">Company Name</label>
                <input id="company_name" class="form-input" type="text" name="company_name" value="{{ old('company_name') }}" required>
            </p>

            <p>
                <label class="form-label" for="admin_name">Admin Name</label>
                <input id="admin_name" class="form-input" type="text" name="admin_name" value="{{ old('admin_name') }}" required>
            </p>

            <p>
                <label class="form-label" for="email">Admin Email</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required>
            </p>

            <p>
                <label class="form-label" for="password">Password</label>
                <input id="password" class="form-input" type="password" name="password" required>
            </p>

            <div class="form-actions">
                <button class="btn-primary" type="submit">Create Company</button>
                <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('superadmin.dashboard') }}'">Back to Dashboard</button>
            </div>
        </form>
    </div>
</div>

@endsection