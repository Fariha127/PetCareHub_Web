@extends('layouts.dashboard')

@section('title', 'Book Appointment | PetCareHub')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <a href="{{ route('dashboard.appointments.index') }}" class="btn btn-link text-decoration-none p-0 text-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Back to Appointments
        </a>
        <h1 class="h3 fw-bold mb-1">Book Pet Appointment</h1>
        <p class="text-muted small m-0">Schedule a medical consultation, checkup, or vaccination session.</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="content-card p-4 p-md-5 border-0 shadow-sm">
                @if($pets->isEmpty())
                    <div class="alert alert-warning border-0 rounded-3 mb-0 p-4">
                        <div class="d-flex gap-3">
                            <span class="fs-3 text-warning"><i class="bi bi-exclamation-triangle-fill"></i></span>
                            <div>
                                <h4 class="h6 fw-bold m-0 text-dark">No Adopted Pets Found</h4>
                                <p class="m-0 small mt-1 text-secondary">You can only book veterinary appointments for pets you have successfully adopted. Browse our available pets and complete an adoption application first.</p>
                                <a href="{{ route('pets.index') }}" class="btn btn-warning btn-sm mt-3 fw-semibold">Browse Available Pets</a>
                            </div>
                        </div>
                    </div>
                @else
                    <form method="POST" action="{{ route('dashboard.appointments.store') }}" class="vstack gap-4">
                        @csrf

                        <!-- Pet Selection -->
                        <div>
                            <label for="pet_id" class="form-label fw-semibold">Select Pet <span class="text-danger">*</span></label>
                            <select name="pet_id" id="pet_id" class="form-select @error('pet_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Choose your pet...</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}" @selected(old('pet_id') == $pet->id)>{{ $pet->name }} ({{ $pet->breed ?? $pet->species }})</option>
                                @endforeach
                            </select>
                            @error('pet_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Vet Selection -->
                        <div>
                            <label for="vet_id" class="form-label fw-semibold">Select Veterinarian <span class="text-danger">*</span></label>
                            <select name="vet_id" id="vet_id" class="form-select @error('vet_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Choose doctor...</option>
                                @foreach($vets as $vet)
                                    <option value="{{ $vet->id }}" @selected(old('vet_id') == $vet->id)>{{ $vet->name }} - {{ $vet->occupation ?? 'Veterinarian' }}</option>
                                @endforeach
                            </select>
                            @error('vet_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date & Time -->
                        <div>
                            <label for="appointment_date" class="form-label fw-semibold">Preferred Date & Time <span class="text-danger">*</span></label>
                            <input
                                type="datetime-local"
                                name="appointment_date"
                                id="appointment_date"
                                value="{{ old('appointment_date') }}"
                                class="form-control @error('appointment_date') is-invalid @enderror"
                                required
                            >
                            @error('appointment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Reason -->
                        <div>
                            <label for="reason" class="form-label fw-semibold">Reason for Appointment <span class="text-danger">*</span></label>
                            <textarea
                                name="reason"
                                id="reason"
                                rows="5"
                                class="form-control @error('reason') is-invalid @enderror"
                                placeholder="Describe the symptoms, routine vaccine name, or purpose of visit..."
                                required
                            >{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <a href="{{ route('dashboard.appointments.index') }}" class="btn btn-light px-4 py-2.5">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 py-2.5 fw-semibold">
                                <i class="bi bi-calendar-check me-1"></i> Confirm Appointment
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="content-card p-4 border-0 shadow-sm">
                <h3 class="h6 fw-bold text-uppercase text-secondary mb-3"><i class="bi bi-info-circle me-1"></i> Medical Info</h3>
                <p class="text-muted small leading-relaxed">
                    Veterinary sessions are hosted at the **PetCareHub Central Clinic**. 
                </p>
                <p class="text-muted small leading-relaxed mb-0">
                    Once submitted, our veterinarians will review your preferred date and time to avoid schedule overlaps. Please arrive **10 minutes before** your scheduled slot.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
