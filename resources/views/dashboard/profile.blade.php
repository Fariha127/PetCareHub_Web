@extends('layouts.dashboard')

@section('title', 'My Profile | PetCareHub')

@section('content')
    <div class="mb-4">
        <h1 class="page-title mb-1">My Profile</h1>
        <p class="text-secondary mb-0">Manage your account information and preferences.</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-md-5 col-lg-4">
            <!-- Profile Avatar Card -->
            <div class="content-card text-center p-4">
                <div class="d-flex justify-content-center mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" 
                         style="width: 90px; height: 90px; background: linear-gradient(135deg, var(--brand-green), var(--brand-green-light)); font-size: 2.2rem; letter-spacing: 1px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
                <h3 class="h5 mb-1 fw-bold">{{ $user->name }}</h3>
                <p class="text-secondary small mb-3">{{ $user->email }}</p>
                
                <span class="badge bg-light text-dark border rounded-pill px-3 py-2 small fw-semibold">
                    <i class="bi bi-shield-lock me-1 text-success"></i> {{ $user->role_display }}
                </span>
                
                <div class="border-top mt-4 pt-3 text-start">
                    <div class="d-flex justify-content-between mb-2 small text-secondary">
                        <span>Account Created</span>
                        <span class="fw-medium text-dark">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-7 col-lg-8">
            <!-- Account Details Card -->
            <div class="content-card p-4">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
                    <h2 class="h5 mb-0 fw-bold">Personal Details</h2>
                    <a href="{{ route('dashboard.profile.edit') }}" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-pencil me-1"></i> Edit Profile
                    </a>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label class="form-label text-secondary small fw-semibold uppercase">Full Name</label>
                        <p class="fs-6 border rounded-pill px-3 py-2 bg-light mb-0">{{ $user->name }}</p>
                    </div>

                    <div class="col-12 col-sm-6">
                        <label class="form-label text-secondary small fw-semibold uppercase">Email Address</label>
                        <p class="fs-6 border rounded-pill px-3 py-2 bg-light mb-0">{{ $user->email }}</p>
                    </div>

                    <div class="col-12 col-sm-6">
                        <label class="form-label text-secondary small fw-semibold uppercase">Phone Number</label>
                        <p class="fs-6 border rounded-pill px-3 py-2 bg-light mb-0">{{ $user->phone ?? 'Not specified' }}</p>
                    </div>

                    @if(!$user->isShelterStaff())
                        <div class="col-12 col-sm-6">
                            <label class="form-label text-secondary small fw-semibold uppercase">Occupation</label>
                            <p class="fs-6 border rounded-pill px-3 py-2 bg-light mb-0">{{ $user->occupation ?? 'Not specified' }}</p>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label class="form-label text-secondary small fw-semibold uppercase">Role Privilege</label>
                            <p class="fs-6 border rounded-pill px-3 py-2 bg-light mb-0">{{ $user->role_display }}</p>
                        </div>
                    @endif

                    <div class="col-12 col-sm-6">
                        <label class="form-label text-secondary small fw-semibold uppercase">Account Status</label>
                        <p class="fs-6 border rounded-pill px-3 py-2 bg-light mb-0">
                            <span class="d-inline-flex align-items-center text-success fw-semibold">
                                <span class="bg-success rounded-circle me-2" style="width: 8px; height: 8px; display: inline-block;"></span>
                                Active
                            </span>
                        </p>
                    </div>

                    <div class="col-12">
                        <label class="form-label text-secondary small fw-semibold uppercase">Address</label>
                        <p class="fs-6 border rounded px-3 py-2 bg-light mb-0" style="border-radius: 15px;">{{ $user->address ?? 'Not specified' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
