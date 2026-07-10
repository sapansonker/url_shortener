@extends('layouts.app')

@section('content')

<style>
    .companies-container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 1.5rem;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .companies-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .companies-heading { font-size:1.9rem; font-weight:700; color:#111827; margin:0; }
    .companies-subtitle { margin:0.35rem 0 0; color:#475569; }

    .back-button { display:inline-flex; padding:0.8rem 1.1rem; border-radius:0.75rem; background:#2563eb; color:#fff; text-decoration:none; }
    .table-wrapper { border:1px solid #e5e7eb; border-radius:1rem; overflow:hidden; background:#fff; box-shadow:0 10px 30px rgba(15,23,42,0.06); }
    .companies-table { width:100%; border-collapse:collapse; }
    .companies-table th, .companies-table td { padding:1rem 1.1rem; border-bottom:1px solid #e5e7eb; text-align:left; }
    .companies-table th { background:#f8fafc; font-weight:700; }
    .companies-empty td{ padding:2rem; text-align:center; color:#6b7280; }
    .pagination-wrap { display:flex; justify-content:flex-end; margin-top:1rem; }
</style>

<div class="companies-container">
    <div class="companies-header">
        <div>
            <h3 class="companies-heading">All Clients</h3>
            <p class="companies-subtitle">Showing {{ $companies->firstItem() ?? 0 }} to {{ $companies->lastItem() ?? 0 }} of {{ $companies->total() }} clients</p>
        </div>
        <a class="back-button" href="{{ route('superadmin.dashboard') }}">Back to Dashboard</a>
    </div>

    <div class="table-wrapper">
        <table class="companies-table" border="0" cellpadding="0">
            <tr>
                <th>Client Name</th>
                <th>Users</th>
                <th>Total Generated URLs</th>
                <th>Total URL Hits</th>
            </tr>

            @forelse($companies as $company)
                <tr>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->total_users }}</td>
                    <td>{{ $company->total_urls }}</td>
                    <td>{{ $company->total_hits }}</td>
                </tr>
            @empty
                <tr class="companies-empty"><td colspan="4">No Clients Found</td></tr>
            @endforelse
        </table>
    </div>

    <div class="pagination-wrap">{{ $companies->links() }}</div>
</div>

@endsection
