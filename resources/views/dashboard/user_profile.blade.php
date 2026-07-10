@extends('layouts.dashboard')

@section('title', 'User Profile | PetCareHub')

@section('content')
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="row g-4">
        <!-- User Personal Details -->
        <div class="col-lg-4">
            <div class="content-card text-center p-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle fw-bold mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="h4 mb-1 fw-bold text-dark">{{ $user->name }}</h2>
                <span class="badge bg-secondary rounded-pill px-3 py-1 mb-4">{{ $user->role_display }}</span>

                <div class="text-start border-top pt-3">
                    <div class="mb-3">
                        <span class="small text-secondary fw-semibold text-uppercase d-block mb-1">Email Address</span>
                        <a href="mailto:{{ $user->email }}" class="text-success text-decoration-none fw-semibold">{{ $user->email }}</a>
                    </div>
                    <div class="mb-3">
                        <span class="small text-secondary fw-semibold text-uppercase d-block mb-1">Phone Number</span>
                        <span class="text-dark fw-semibold">{{ $user->phone ?? 'Not specified' }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="small text-secondary fw-semibold text-uppercase d-block mb-1">Occupation</span>
                        <span class="text-dark fw-semibold">{{ $user->occupation ?? 'Not specified' }}</span>
                    </div>
                    <div class="mb-0">
                        <span class="small text-secondary fw-semibold text-uppercase d-block mb-1">Address</span>
                        <span class="text-dark small d-block">{{ $user->address ?? 'Not specified' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Adoption Application History -->
        <div class="col-lg-8">
            <div class="content-card">
                <div class="p-3 border-bottom">
                    <h2 class="h5 mb-0">Adoption Application History</h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Pet</th>
                                <th>Status</th>
                                <th>Applicant Message</th>
                                <th>Date Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $app)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($app->pet && $app->pet->image_url)
                                                <img src="{{ $app->pet->image_url }}" alt="{{ $app->pet->name }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <span class="fw-semibold text-dark">{{ $app->pet->name ?? 'N/A' }}</span>
                                                <span class="text-secondary small d-block">{{ $app->pet->species ?? '' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $app->status }} rounded-pill px-2 py-1">
                                            {{ ucfirst($app->status) }}
                                        </span>
                                    </td>
                                    <td class="small text-secondary" style="max-width: 250px;">
                                        {{ $app->message }}
                                        @if($app->admin_notes)
                                            <div class="mt-1 text-danger small">
                                                <strong>Staff Note:</strong> {{ $app->admin_notes }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-secondary small">{{ $app->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-secondary py-4">
                                        No adoption applications from this user yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
