@extends('layouts.dashboard')

@section('title', 'My Appointments | PetCareHub')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">My Pet Appointments</h1>
            <p class="text-muted small m-0">Schedule and manage medical and checkup appointments for your adopted pets.</p>
        </div>
        <a href="{{ route('dashboard.appointments.create') }}" class="btn btn-primary px-4 py-2">
            <i class="bi bi-calendar-plus me-1"></i> Book Appointment
        </a>
    </div>

    <div class="content-card p-4 border-0 shadow-sm">
        @if($appointments->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-calendar3 display-4 text-secondary mb-3 d-block"></i>
                <h3 class="h5 fw-bold text-dark mb-2">No Appointments Scheduled</h3>
                <p class="text-muted small mb-4">Need to take your pet for a vaccination or checkup? Schedule a session with one of our veterinarians.</p>
                <a href="{{ route('dashboard.appointments.create') }}" class="btn btn-primary px-4">Book Your First Appointment</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead>
                        <tr class="text-secondary small uppercase fw-bold border-bottom">
                            <th scope="col" class="py-3">Pet</th>
                            <th scope="col" class="py-3">Veterinarian</th>
                            <th scope="col" class="py-3">Date & Time</th>
                            <th scope="col" class="py-3">Purpose</th>
                            <th scope="col" class="py-3">Status</th>
                            <th scope="col" class="py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr class="border-bottom">
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $appointment->pet->image_url }}" alt="{{ $appointment->pet->name }}" class="rounded-circle object-fit-cover" style="width: 42px; height: 42px;">
                                        <div>
                                            <h4 class="h6 fw-bold m-0 text-dark">{{ $appointment->pet->name }}</h4>
                                            <small class="text-muted">{{ $appointment->pet->breed ?? $appointment->pet->species }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="fw-semibold text-dark">{{ $appointment->vet->name }}</div>
                                    <small class="text-muted">{{ $appointment->vet->email }}</small>
                                </td>
                                <td class="py-3">
                                    <div class="fw-semibold text-dark">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $appointment->appointment_date->format('h:i A') }}</small>
                                </td>
                                <td class="py-3">
                                    <span class="d-inline-block text-truncate" style="max-width: 250px;" title="{{ $appointment->reason }}">
                                        {{ $appointment->reason }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    @if($appointment->isPending())
                                        <span class="badge rounded-pill bg-warning text-dark px-3 py-2 fw-semibold">Pending Approval</span>
                                    @elseif($appointment->isApproved())
                                        <span class="badge rounded-pill bg-success text-white px-3 py-2 fw-semibold">Approved</span>
                                    @elseif($appointment->isRejected())
                                        <span class="badge rounded-pill bg-danger text-white px-3 py-2 fw-semibold">Rejected</span>
                                    @elseif($appointment->isCancelled())
                                        <span class="badge rounded-pill bg-secondary text-white px-3 py-2 fw-semibold">Cancelled</span>
                                    @elseif($appointment->isCompleted())
                                        <span class="badge rounded-pill bg-info text-dark px-3 py-2 fw-semibold">Completed</span>
                                    @endif
                                </td>
                                <td class="py-3 text-end">
                                    @if(in_array($appointment->status, ['pending', 'approved']))
                                        <form method="POST" action="{{ route('dashboard.appointments.cancel', $appointment) }}" onsubmit="return confirm('Are you sure you want to cancel this appointment?');" class="d-inline-block m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-1.5 fw-semibold">
                                                <i class="bi bi-calendar-x me-1"></i> Cancel
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
