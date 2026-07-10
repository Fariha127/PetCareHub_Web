@extends('layouts.dashboard')

@section('title', 'Staff Dashboard | PetCareHub')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Shelter Staff Dashboard</h1>
            <p class="text-secondary mb-0">Manage pets, review adoption applications, and generate reports.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pets.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Pet
            </a>
            <a href="{{ route('reports.adoption') }}" class="btn btn-outline-success">
                <i class="bi bi-bar-chart-line me-1"></i> Reports
            </a>
        </div>
    </div>

    <!-- Stat cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-2">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #e9f7ef; color: #198754;">
                    <i class="bi bi-heart-pulse"></i>
                </div>
                <div class="stat-value">{{ $totalPets }}</div>
                <div class="stat-label">Total Pets</div>
            </div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #cfe2ff; color: #084298;">
                    <i class="bi bi-check2-square"></i>
                </div>
                <div class="stat-value">{{ $availablePets }}</div>
                <div class="stat-label">Available</div>
            </div>
        </div>
        <div class="col-6 col-lg-2">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #d1e7dd; color: #0f5132;">
                    <i class="bi bi-house-heart"></i>
                </div>
                <div class="stat-value">{{ $adoptedPets }}</div>
                <div class="stat-label">Adopted</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #fff3cd; color: #856404;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-value">{{ $pendingApplications }}</div>
                <div class="stat-label">Pending Applications</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #f0e6ff; color: #6f42c1;">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div class="stat-value">{{ $totalApplications }}</div>
                <div class="stat-label">Total Applications</div>
            </div>
        </div>
    </div>

    <!-- Applications table -->
    <div class="content-card">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
            <h2 class="h5 mb-0">Adoption Applications</h2>
            <span class="text-secondary small">{{ $pendingApplications }} pending review</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Applicant</th>
                        <th>Pet</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                        <tr>
                            <td class="text-secondary">{{ $app->id }}</td>
                            <td class="fw-semibold">
                                <a href="{{ route('dashboard.users.show', $app->user_id) }}" class="text-decoration-none text-success">
                                    {{ $app->user->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('pets.show', $app->pet_id) }}" class="text-decoration-none text-success">
                                    {{ $app->pet->name ?? 'N/A' }}
                                </a>
                                <span class="text-secondary small d-block">{{ $app->pet->species ?? '' }}</span>
                            </td>
                            <td class="small text-secondary" style="max-width: 200px;">{{ Str::limit($app->message, 60) }}</td>
                            <td class="text-secondary small">{{ $app->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $app->status }} rounded-pill px-2 py-1">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                @if($app->isPending())
                                    <div class="d-flex gap-1 justify-content-end">
                                        <form method="POST" action="{{ route('applications.approve', $app) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                <i class="bi bi-check-lg"></i> Approve
                                            </button>
                                        </form>
                                        
                                        <!-- Reject Trigger Button -->
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $app->id }}" title="Reject">
                                            <i class="bi bi-x-lg"></i> Reject
                                        </button>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal-{{ $app->id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $app->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered text-start">
                                                <div class="modal-content shadow-lg border-0">
                                                    <form method="POST" action="{{ route('applications.reject', $app) }}">
                                                        @csrf
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title fw-bold" id="rejectModalLabel-{{ $app->id }}">
                                                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Reject Application
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="mb-3 text-secondary">
                                                                Are you sure you want to reject <strong>{{ $app->user->name }}</strong>'s application to adopt <strong>{{ $app->pet->name }}</strong>?
                                                            </p>
                                                            <div class="mb-0">
                                                                <label for="admin_notes-{{ $app->id }}" class="form-label small fw-semibold text-secondary">Reason for Rejection <span class="text-danger">*</span></label>
                                                                <textarea id="admin_notes-{{ $app->id }}" name="admin_notes" class="form-control" rows="3" placeholder="Please provide a clear explanation for the adopter..." required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-sm btn-danger px-3 fw-semibold">Confirm Rejection</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-secondary small">
                                        @if($app->reviewer)
                                            by {{ $app->reviewer->name }}
                                        @endif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-4">
                                No adoption applications yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
