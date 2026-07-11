@extends('layouts.app')

@section('content')

<style>
    .dashboard-container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 1.5rem;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .dashboard-heading {
        font-size: 1.75rem;
        margin-bottom: 1rem;
        color: #111827;
        font-weight: 700;
    }

    .dashboard-section {
        margin-bottom: 2rem;
    }

    .dashboard-form {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .dashboard-input {
        min-width: 280px;
        width: 100%;
        max-width: 500px;
        padding: 0.85rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
    }

    .dashboard-button {
        padding: 0.85rem 1.25rem;
        border: none;
        border-radius: 0.75rem;
        background: #2563eb;
        color: #ffffff;
        font-weight: 600;
        cursor: pointer;
    }

    .dashboard-button:hover {
        background: #1d4ed8;
    }

    .dashboard-table-wrapper {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
    }

    .dashboard-table th,
    .dashboard-table td {
        padding: 1rem 1.1rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: top;
    }

    .dashboard-table th {
        background: #f9fafb;
        font-weight: 700;
        color: #111827;
    }

    .dashboard-table tr:last-child td {
        border-bottom: none;
    }

    .dashboard-table tr:nth-child(even) td {
        background: #f9fafb;
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

    .dashboard-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .dashboard-summary {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 1rem;
        padding-top: 1rem;
        color: #4b5563;
        font-size: 0.95rem;
    }

    .dashboard-empty td {
        text-align: center;
        color: #6b7280;
    }
</style>

<div class="dashboard-container">

<div class="dashboard-section">
    <hr>
    <div class="dashboard-section-header">
        <div>
            <h3 class="dashboard-heading">Generated Short URLs</h3>
        </div>
        <div style="display:flex; flex-wrap:wrap; gap:0.75rem; align-items:center;">
            <form method="GET" action="{{ route('admin.dashboard') }}" style="display:flex; flex-wrap:wrap; gap:0.75rem; align-items:center;">
                <select name="date_range" class="dashboard-input" style="max-width:220px;">
                    <option value="">All time</option>
                    <option value="today" {{ ($dateRange ?? '') === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="last_week" {{ ($dateRange ?? '') === 'last_week' ? 'selected' : '' }}>Last week</option>
                    <option value="last_month" {{ ($dateRange ?? '') === 'last_month' ? 'selected' : '' }}>Last month</option>
                </select>
                <button type="submit" class="dashboard-button">Filter</button>
            </form>
            <button class="dashboard-button" onclick="window.location.href='{{ route('admin.urls.create') }}'">Generate</button>
            <button class="dashboard-button" onclick="window.location.href='{{ route('urls.download', ['date_range' => $dateRange ?? '']) }}'">Download</button>
        </div>
    </div>

    <table class="dashboard-table" border="1" cellpadding="10">
        <tr>
            <th>Short URL</th>
            <th>Long URL</th>
            <th>Hits</th>
            <th>User</th>
            <th>Created On</th>
        </tr>

        @if($urls->isEmpty())
            <tr>
                <td colspan="5">No URLs Found</td>
            </tr>
        @else
            @foreach($urls->take(2) as $url)
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
            @endforeach
        @endif
    </table>

    <div class="dashboard-summary">
        <span>Showing {{ min(2, $urls->count()) }} of {{ $urls->count() }} urls</span>
        @if($urls->count() > 2)
            <a class="dashboard-action-link" href="{{ route('admin.urls') }}">View All</a>
        @endif
    </div>
</div>

<br>
<div class="dashboard-section">
    <hr>
    <div class="dashboard-section-header">
        <h3 class="dashboard-heading">Team Members</h3>
        <button class="dashboard-button" onclick="window.location.href='{{ route('member.create') }}'">Invite</button>
    </div>
        <div class="dashboard-table-wrapper">
            <table class="dashboard-table" border="0" cellpadding="0">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Total Generated URLs</th>
                    <th>Total Hits</th>
                </tr>

                @if($members->isEmpty())
                    <tr class="dashboard-empty">
                        <td colspan="5">No Members Found</td>
                    </tr>
                @else
                    @foreach($members->take(2) as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ ucfirst($member->role) }}</td>
                            <td>{{ $member->total_urls }}</td>
                            <td>{{ $member->total_hits }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>

        <div class="dashboard-summary">
            <span>Showing {{ min(2, $members->count()) }} of {{ $members->count() }} members</span>
            @if($members->count() > 2)
                <a class="dashboard-action-link" href="{{ route('admin.members') }}">View All</a>
            @endif
        </div>
@endsection