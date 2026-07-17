@extends('layouts.dashboard')

@section('title', 'My Dashboard | PetCareHub')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-secondary mb-0">Track your adoption applications and discover new pets.</p>
        </div>
        <a href="{{ route('pets.index') }}" class="btn btn-primary">
            <i class="bi bi-search-heart me-1"></i> Browse Pets
        </a>
    </div>

    <!-- Notifications & Reminders Section -->
    @if($checkupNotifications->isNotEmpty())
        <div class="content-card mb-4 border-warning bg-warning-subtle" style="border-left: 5px solid #ffc107 !important;">
            <div class="p-3">
                <h2 class="h6 fw-bold mb-3 text-warning-emphasis">
                    <i class="bi bi-bell-fill me-2 text-warning"></i>Notifications & Reminders
                </h2>
                <div class="d-flex flex-column gap-3">
                    @foreach($checkupNotifications as $notification)
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-3 bg-white rounded border border-warning-subtle shadow-sm">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                    <i class="bi bi-heart-pulse-fill"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-bold text-dark mb-1">Upcoming Medical Checkup for {{ $notification->pet->name }}</h3>
                                    <p class="text-secondary small mb-0">
                                        Scheduled for <strong>{{ $notification->next_checkup_date->format('F d, Y') }}</strong> (Originally recommended during checkup on {{ $notification->checkup_date->format('M d, Y') }}).
                                    </p>
                                </div>
                            </div>
                            <div>
                                <form method="POST" action="{{ route('checkups.mark-done', $notification) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold">
                                        <i class="bi bi-check2-circle me-1"></i> Mark as Done
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Stat cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #e9f7ef; color: #198754;">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div class="stat-value">{{ $totalApplications }}</div>
                <div class="stat-label">Total Applications</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #fff3cd; color: #856404;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-value">{{ $pendingCount }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #d1e7dd; color: #0f5132;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-value">{{ $approvedCount }}</div>
                <div class="stat-label">Approved</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #cfe2ff; color: #084298;">
                    <i class="bi bi-heart"></i>
                </div>
                <div class="stat-value">{{ $availablePetsCount }}</div>
                <div class="stat-label">Pets Available</div>
            </div>
        </div>
    </div>

    <!-- Applications table -->
    <div class="content-card">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
            <h2 class="h5 mb-0">My Adoption Applications</h2>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Pet</th>
                        <th>Species</th>
                        <th>Applied On</th>
                        <th>Status</th>
                        <th>Staff Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                        <tr>
                            <td>
                                <a href="{{ route('pets.show', $app->pet_id) }}" class="text-decoration-none fw-semibold text-success">
                                    {{ $app->pet->name ?? 'N/A' }}
                                </a>
                            </td>
                            <td>{{ $app->pet->species ?? '-' }}</td>
                            <td>{{ $app->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $app->status }} rounded-pill px-2 py-1">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td class="text-secondary small">{{ Str::limit($app->admin_notes, 50) ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-4">
                                No applications yet. <a href="{{ route('pets.index') }}" class="text-success">Browse available pets</a> to get started!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
