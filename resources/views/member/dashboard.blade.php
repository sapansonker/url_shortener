@extends('layouts.app')

@section('content')

<style>
    .member-dashboard {
        max-width: 960px;
        margin: 0 auto;
        padding: 1.5rem;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .member-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .member-card h2,
    .member-card h3 {
        margin-top: 0;
        color: #111827;
    }

    .member-title-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.85rem 1.25rem;
        border-radius: 0.75rem;
        background: #2563eb;
        color: #ffffff;
        text-decoration: none;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .urls-table-wrapper {
        overflow-x: auto;
        margin-top: 1rem;
    }

    .urls-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 640px;
    }

    .urls-table th,
    .urls-table td {
        padding: 1rem 1.1rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    .urls-table th {
        background: #f8fafc;
        font-weight: 700;
        color: #111827;
    }

    .urls-table tr:nth-child(even) td {
        background: #f8fafc;
    }

    .urls-table a {
        color: #2563eb;
        text-decoration: none;
    }

    .urls-table a:hover {
        text-decoration: underline;
    }

    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
</style>

<div class="member-dashboard">
    <div class="member-card">
        <div class="member-title-row">
            <div>
                <h2>Member Dashboard</h2>
                <p style="margin:0; color:#475569;">Manage & generate short URLs.</p>
            </div>
            <a class="btn-primary" href="{{ route('member.urls.create') }}">Generate</a>
        </div>
    </div>

    <div class="member-card">
        <div class="member-title-row">
            <h3>Generated Short URLs</h3>
            <div style="display:flex; gap:0.75rem; align-items:center;">
                <form method="GET" action="{{ route('member.dashboard') }}" style="display:flex; gap:0.5rem; align-items:center;">
                    <select name="date_range" style="padding:0.5rem 0.75rem; border:1px solid #d1d5db; border-radius:0.5rem;">
                        <option value="">All time</option>
                        <option value="today" {{ ($dateRange ?? '') === 'today' ? 'selected' : '' }}>Today</option>
                        <option value="last_week" {{ ($dateRange ?? '') === 'last_week' ? 'selected' : '' }}>Last week</option>
                        <option value="last_month" {{ ($dateRange ?? '') === 'last_month' ? 'selected' : '' }}>Last month</option>
                    </select>
                    <button type="submit" class="btn-primary">Filter</button>
                </form>
            </div>
        </div>

        <div class="urls-table-wrapper">
            <table class="urls-table">
                <tr>
                    <th>Short URL</th>
                    <th>Original URL</th>
                    <th>Hits</th>
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
                    <td>{{ $url->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">No URLs Found</td>
                </tr>
                @endforelse
            </table>
        </div>

        <div class="table-footer">
            <div>{{ $urls->links() }}</div>
        </div>
    </div>
</div>

@endsection