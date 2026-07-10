@extends('layouts.app')

@section('content')

<style>
    .urls-container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 1.5rem;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .urls-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.25rem;
    }

    .urls-heading {
        font-size: 1.9rem;
        color: #111827;
        font-weight: 700;
        margin: 0;
    }

    .urls-subtitle {
        margin: 0.5rem 0 0;
        color: #4b5563;
        font-size: 0.95rem;
    }

    .urls-action-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.85rem 1.4rem;
        border-radius: 0.75rem;
        text-decoration: none;
        font-weight: 600;
        border: 1px solid #2563eb;
        background: #2563eb;
        color: #ffffff;
    }

    .urls-action-link:hover {
        background: #1d4ed8;
    }

    .urls-table-wrapper {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    }

    .urls-table {
        width: 100%;
        border-collapse: collapse;
    }

    .urls-table th,
    .urls-table td {
        padding: 1rem 1.1rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: top;
    }

    .urls-table th {
        background: #f9fafb;
        font-weight: 700;
        color: #111827;
    }

    .urls-table tr:last-child td {
        border-bottom: none;
    }

    .urls-table tr:nth-child(even) td {
        background: #f8fafc;
    }

    .urls-table a {
        color: #1d4ed8;
        text-decoration: none;
    }

    .urls-table a:hover {
        text-decoration: underline;
    }

    .urls-empty td {
        text-align: center;
        color: #6b7280;
        padding: 2rem;
    }

    .urls-pagination {
        display: flex;
        justify-content: flex-end;
        margin-top: 1.25rem;
    }

    .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .pagination li {
        display: inline-flex;
    }

    .pagination a,
    .pagination span {
        min-width: 2.75rem;
        padding: 0.7rem 0.9rem;
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
        background: #ffffff;
        color: #374151;
        text-decoration: none;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .pagination a:hover {
        background: #f3f4f6;
        border-color: #cbd5e1;
    }

    .pagination .active span {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .pagination .disabled span {
        color: #9ca3af;
        border-color: #e5e7eb;
        background: #f9fafb;
    }
</style>

<div class="urls-container">
    <div class="urls-header">
        <div>
            <h3 class="urls-heading">Generated Short URLs</h3>
            <p class="urls-subtitle">Showing {{ $urls->firstItem() ?? 0 }} to {{ $urls->lastItem() ?? 0 }} of total {{ $urls->total() }} urls</p>
        </div>
        <div style="display:flex; flex-wrap:wrap; gap:0.75rem; align-items:center;">
            <form method="GET" action="{{ route('admin.urls') }}" style="display:flex; flex-wrap:wrap; gap:0.75rem; align-items:center;">
                <select name="date_range" style="padding:0.85rem 1rem; border:1px solid #d1d5db; border-radius:0.75rem; background:#ffffff; color:#111827; font-weight:600; min-width:160px;">
                    <option value="">All time</option>
                    <option value="today" {{ ($dateRange ?? '') === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="last_week" {{ ($dateRange ?? '') === 'last_week' ? 'selected' : '' }}>Last week</option>
                    <option value="last_month" {{ ($dateRange ?? '') === 'last_month' ? 'selected' : '' }}>Last month</option>
                </select>
                <button type="submit" class="urls-action-link">Filter</button>
            </form>
            <a class="urls-action-link" href="{{ route('urls.download', ['date_range' => $dateRange ?? '']) }}">Download</a>
            <a class="urls-action-link" href="{{ route('admin.dashboard', ['date_range' => $dateRange ?? '']) }}">Back to Dashboard</a>
        </div>
    </div>

    <div class="urls-table-wrapper">
        <table class="urls-table" border="0" cellpadding="0">
            <tr>
                <th>Short URL</th>
                <th>Long URL</th>
                <th>Hits</th>
                <th>User</th>
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
                    <td>{{ $url->user_name }}</td>
                    <td>{{ $url->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @empty
                <tr class="urls-empty">
                    <td colspan="5">No URLs Found</td>
                </tr>
            @endforelse
        </table>
    </div>

    <div class="urls-pagination">
        {{ $urls->links() }}
    </div>
</div>

@endsection
