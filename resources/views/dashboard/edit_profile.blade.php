@extends('layouts.dashboard')

@section('title', 'Edit Profile | PetCareHub')

@section('content')
    <div class="mb-4">
        <h1 class="page-title mb-1">Edit Profile</h1>
        <p class="text-secondary mb-0">Update your personal information and login credentials.</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="content-card p-4">
                <form method="POST" action="{{ route('dashboard.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                        <h2 class="h5 mb-0 fw-bold">Update Account Information</h2>
                        <a href="{{ route('dashboard.profile') }}" class="btn btn-sm btn-light border">
                            <i class="bi bi-arrow-left me-1"></i> Cancel
                        </a>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6">
                            <label for="name" class="form-label small fw-semibold text-secondary">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6">
                            <label for="email" class="form-label small fw-semibold text-secondary">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6">
                            <label for="phone" class="form-label small fw-semibold text-secondary">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+880 01XXXXXXXXX">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(!$user->isShelterStaff())
                            <div class="col-12 col-sm-6">
                                <label for="occupation" class="form-label small fw-semibold text-secondary">Occupation</label>
                                <input type="text" class="form-control @error('occupation') is-invalid @enderror" id="occupation" name="occupation" value="{{ old('occupation', $user->occupation) }}" placeholder="e.g. Designer, Teacher">
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="col-12">
                            <label for="address" class="form-label small fw-semibold text-secondary">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user->address) }}" placeholder="Street, City, State/Zip">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="border-top pt-4 mb-4">
                        <h3 class="h6 fw-bold text-dark mb-2">Change Password</h3>
                        <p class="text-secondary small mb-3">Leave these fields blank if you do not wish to change your password.</p>
                        
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label for="password" class="form-label small fw-semibold text-secondary">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-3 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
