@extends('layouts.app')

@section('content')

<style>
    .create-url-page {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 70vh;
        padding: 1.25rem;
        background: #f8fafc;
    }

    .create-url-card {
        width: 100%;
        max-width: 520px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        padding: 1.5rem;
    }

    .create-url-card h2 {
        margin: 0 0 0.6rem;
        font-size: 1.75rem;
        color: #111827;
    }

    .form-label { display:block; margin-bottom:0.35rem; font-weight:600; color:#111827; }
    .form-input { width:100%; padding:0.95rem 1rem; border:1px solid #d1d5db; border-radius:0.75rem; font-size:0.98rem; }
    .form-input:focus { outline:none; border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.15); }

    .form-actions { display:grid; gap:0.75rem; margin-top:1.25rem; }
    .btn-primary { width:100%; padding:0.95rem 1rem; border-radius:0.75rem; background:#2563eb; color:#ffffff; border:1px solid #2563eb; font-weight:600; }
    .btn-secondary { width:100%; padding:0.95rem 1rem; border-radius:0.75rem; background:#f8fafc; color:#111827; border:1px solid #d1d5db; font-weight:600; }
    .btn-primary:hover { background:#1d4ed8; }
    .btn-secondary:hover { background:#eef2ff; }

    .errors { background:#fff1f2; border:1px solid #fecaca; padding:0.75rem; border-radius:0.55rem; color:#b91c1c; margin-bottom:1rem; }
</style>

<div class="create-url-page">
    <div class="create-url-card">
        <h2>Generate Short URL</h2>
        <p style="margin:0 0 1rem; color:#475569;">Enter the destination URL to generate a short link.</p>

        @if($errors->any())
            <div class="errors">
                <ul style="margin:0; padding-left:1.2rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('urls.store') }}">
            @csrf

            <p>
                <label class="form-label" for="original_url">Original URL</label>
                <input id="original_url" class="form-input" type="url" name="original_url" value="{{ old('original_url') }}" placeholder="https://example.com" required>
            </p>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Generate</button>
                <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('member.dashboard') }}'">Back to Dashboard</button>
            </div>
        </form>
    </div>
</div>

@endsection