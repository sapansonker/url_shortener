@extends('layouts.app')

@section('content')

<style>
    .urls-container { max-width:1120px; margin:0 auto; padding:1.5rem; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
    .urls-header { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; margin-bottom:1.25rem; }
    .urls-heading { font-size:1.9rem; font-weight:700; color:#111827; margin:0; }
    .back-button { display:inline-flex; padding:0.8rem 1.1rem; border-radius:0.75rem; background:#2563eb; color:#fff; text-decoration:none; }
    .table-wrapper { border:1px solid #e5e7eb; border-radius:1rem; overflow:hidden; background:#fff; box-shadow:0 10px 30px rgba(15,23,42,0.06); }
    .urls-table { width:100%; border-collapse:collapse; }
    .urls-table th, .urls-table td { padding:1rem 1.1rem; border-bottom:1px solid #e5e7eb; text-align:left; }
    .urls-table th { background:#f8fafc; font-weight:700; }
    .urls-empty td{ padding:2rem; text-align:center; color:#6b7280; }
    .pagination-wrap { display:flex; justify-content:flex-end; margin-top:1rem; }
</style>

<div class="urls-container">
    <div class="urls-header">
        <div>
            <h3 class="urls-heading">All Generated Short URLs</h3>
            <p class="companies-subtitle">Showing {{ $urls->firstItem() ?? 0 }} to {{ $urls->lastItem() ?? 0 }} of {{ $urls->total() }} results</p>
        </div>
        <div style="display:flex; flex-wrap:wrap; gap:0.75rem; align-items:center;">
            <form method="GET" action="{{ route('superadmin.urls') }}" style="display:flex; flex-wrap:wrap; gap:0.75rem; align-items:center;">
                <select name="date_range" style="padding:0.85rem 1rem; border:1px solid #d1d5db; border-radius:0.75rem; background:#ffffff; color:#111827; font-weight:600; min-width:160px;">
                    <option value="">All time</option>
                    <option value="today" {{ ($dateRange ?? '') === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="last_week" {{ ($dateRange ?? '') === 'last_week' ? 'selected' : '' }}>Last week</option>
                    <option value="last_month" {{ ($dateRange ?? '') === 'last_month' ? 'selected' : '' }}>Last month</option>
                </select>
                <button type="submit" class="back-button">Filter</button>
            </form>
            <!-- <a class="back-button" href="{{ route('urls.download', ['date_range' => $dateRange ?? '']) }}">Download</a> -->
            <a class="back-button" href="{{ route('superadmin.dashboard', ['date_range' => $dateRange ?? '']) }}">Back to Dashboard</a>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="urls-table" border="0" cellpadding="0">
            <tr>
                <th>Short URL</th>
                <th>Long URL</th>
                <th>Hits</th>
                <th>Company Name</th>
                <th>Created At</th>
            </tr>

            @forelse($urls as $url)
                <tr>
                    <td><a href="{{ route('urls.redirect', $url->short_code) }}" target="_blank">{{ url('/s/'.$url->short_code) }}</a></td>
                    <td>{{ $url->original_url }}</td>
                    <td>{{ $url->hits }}</td>
                    <td>{{ $url->company_name }}</td>
                    <td>{{ $url->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @empty
                <tr class="urls-empty"><td colspan="5">No URLs Found</td></tr>
            @endforelse
        </table>
    </div>

    <div class="pagination-wrap">{{ $urls->links() }}</div>
</div>

@endsection
