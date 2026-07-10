@extends('layouts.app')

@section('content')

<style>
    .members-container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 1.5rem;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .members-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.25rem;
    }

    .members-heading {
        font-size: 1.9rem;
        color: #111827;
        font-weight: 700;
        margin: 0;
    }

    .members-subtitle {
        margin: 0.5rem 0 0;
        color: #4b5563;
        font-size: 0.95rem;
    }

    .back-button {
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

    .back-button:hover {
        background: #1d4ed8;
    }

    .members-table-wrapper {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    }

    .members-table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
    }

    .members-table th,
    .members-table td {
        padding: 1rem 1.1rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: top;
    }

    .members-table th {
        background: #f9fafb;
        font-weight: 700;
        color: #111827;
    }

    .members-table tr:last-child td {
        border-bottom: none;
    }

    .members-table tr:nth-child(even) td {
        background: #f9fafb;
    }

    .members-empty td {
        text-align: center;
        color: #6b7280;
        padding: 2rem;
    }

    .members-pagination {
        display: flex;
        justify-content: flex-end;
        margin-top: 1.25rem;
    }
</style>

<div class="members-container">
    <div class="members-header">
        <div>
            <h3 class="members-heading">Team Members</h3>
            <p class="members-subtitle">Showing {{ $members->firstItem() ?? 0 }} to {{ $members->lastItem() ?? 0 }} of {{ $members->total() }} members</p>
        </div>
        <a class="back-button" href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
    </div>

    <div class="members-table-wrapper">
        <table class="members-table" border="0" cellpadding="0">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Total Generated URLs</th>
                <th>Total Hits</th>
            </tr>

            @forelse($members as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ ucfirst($member->role) }}</td>
                    <td>{{ $member->total_urls }}</td>
                    <td>{{ $member->total_hits }}</td>
                </tr>
            @empty
                <tr class="members-empty">
                    <td colspan="5">No Members Found</td>
                </tr>
            @endforelse
        </table>
    </div>

    <div class="members-pagination">
        {{ $members->links() }}
    </div>
</div>

@endsection
