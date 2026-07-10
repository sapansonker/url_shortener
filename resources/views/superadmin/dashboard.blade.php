@extends('layouts.app')

@section('content')

<style>
    .superadmin-container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 1.5rem 1rem 2rem;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .superadmin-section {
        margin-bottom: 2rem;
    }

    .superadmin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .superadmin-heading {
        margin: 0;
        font-size: 1.85rem;
        font-weight: 700;
        color: #111827;
    }

    .superadmin-description {
        margin: 0.35rem 0 0;
        color: #475569;
        font-size: 0.95rem;
    }

    .dashboard-action-link {
        margin-left: 0.75rem;
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }

    .dashboard-action-link:hover {
        text-decoration: underline;
    }

    .superadmin-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.85rem 1.25rem;
        border: 1px solid #2563eb;
        border-radius: 0.75rem;
        background: #2563eb;
        color: #ffffff;
        text-decoration: none;
        font-weight: 600;
    }

    .superadmin-button:hover {
        background: #1d4ed8;
    }

    .superadmin-table-wrapper {
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
    }

    .superadmin-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 640px;
    }

    .superadmin-table th,
    .superadmin-table td {
        padding: 1rem 1.1rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: middle;
    }

    .superadmin-table th {
        background: #f8fafc;
        font-weight: 700;
        color: #111827;
    }

    .superadmin-table tr:nth-child(even) td {
        background: #f8fafc;
    }

    .superadmin-table tr:last-child td {
        border-bottom: none;
    }

    .superadmin-table a {
        color: #1d4ed8;
        text-decoration: none;
    }

    .superadmin-table a:hover {
        text-decoration: underline;
    }

    .superadmin-empty td {
        text-align: center;
        color: #6b7280;
        padding: 2rem;
    }
</style>

<div class="superadmin-container">
    <div class="superadmin-section">
        <div class="superadmin-header">
            <div>
                <h3 class="superadmin-heading">Clients</h3>
                <p class="superadmin-description">View and invite client companies.</p>
            </div>
            <a class="superadmin-button" href="{{ route('company.create') }}">Invite Client</a>
        </div>

        <div class="superadmin-table-wrapper">
            <table class="superadmin-table" border="0" cellpadding="0">
                <tr>
                    <th>Client Name</th>
                    <th>Users</th>
                    <th>Total Generated URLs</th>
                    <th>Total URL Hits</th>
                </tr>

                @forelse($companies->take(2) as $company)
                    <tr>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->total_users }}</td>
                        <td>{{ $company->total_urls }}</td>
                        <td>{{ $company->total_hits }}</td>
                    </tr>
                @empty
                    <tr class="superadmin-empty">
                        <td colspan="4">No Clients Found</td>
                    </tr>
                @endforelse
            </table>
        </div>
        <div style="display:flex; justify-content:flex-start; gap:1rem; padding-top:0.75rem;">
            <span style="color:#475569; align-self:center;">Showing {{ min(2, $companies->count()) }} of {{ $companies->count() }} clients</span>
            @if($companies->count() > 2)
                <a class="dashboard-action-link" href="{{ route('superadmin.companies') }}">View All</a>
            @endif
        </div>
    </div>

    <br><br>
    <hr>
    <br>

    <div class="superadmin-section">
        <div class="superadmin-header">
            <div>
                <h3 class="superadmin-heading">Generated Short URLs</h3>
                <p class="superadmin-description">Download or review the latest client-generated links.</p>
            </div>
            <a class="superadmin-button" href="{{ route('urls.download') }}">Download</a>
        </div>

        <div class="superadmin-table-wrapper">
            <table class="superadmin-table" border="0" cellpadding="0">
                <tr>
                    <th>Short URL</th>
                    <th>Long URL</th>
                    <th>Hits</th>
                    <th>Company Name</th>
                    <th>Created At</th>
                </tr>

                @forelse($urls->take(2) as $url)
                    <tr>
                        <td>
                            <a href="{{ route('urls.redirect', $url->short_code) }}" target="_blank">
                                {{ url('/s/'.$url->short_code) }}
                            </a>
                        </td>
                        <td>{{ $url->original_url }}</td>
                        <td>{{ $url->hits }}</td>
                        <td>{{ $url->company_name }}</td>
                        <td>{{ $url->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @empty
                    <tr class="superadmin-empty">
                        <td colspan="5">No URLs Found</td>
                    </tr>
                @endforelse
            </table>
        </div>
        <div style="display:flex; justify-content:flex-start; gap:1rem; padding-top:0.75rem;">
            <span style="color:#475569; align-self:center;">Showing {{ min(2, $urls->count()) }} of {{ $urls->count() }} results</span>
            @if($urls->count() > 2)
                <a class="dashboard-action-link" href="{{ route('superadmin.urls') }}">View All</a>
            @endif
        </div>
    </div>
</div>

@endsection