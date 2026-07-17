@extends('layouts.dashboard')

@section('title', 'Manage Appointments | PetCareHub')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Veterinary Appointments</h1>
        <p class="text-muted small m-0">Review consultation bookings, checkups, and schedule changes.</p>
    </div>

    <div class="content-card p-4 border-0 shadow-sm">
        @if($appointments->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-calendar3-range display-4 text-secondary mb-3 d-block"></i>
                <h3 class="h5 fw-bold text-dark mb-2">No Appointments Found</h3>
                <p class="text-muted small mb-0">You do not have any appointments scheduled with adopters at this time.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead>
                        <tr class="text-secondary small uppercase fw-bold border-bottom">
                            <th scope="col" class="py-3">Adopter</th>
                            <th scope="col" class="py-3">Pet</th>
                            <th scope="col" class="py-3">Scheduled Date</th>
                            <th scope="col" class="py-3">Purpose</th>
                            <th scope="col" class="py-3">Status</th>
                            <th scope="col" class="py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr class="border-bottom">
                                <td class="py-3">
                                    <div class="fw-semibold text-dark">{{ $appointment->user->name }}</div>
                                    <small class="text-muted">{{ $appointment->user->phone ?? 'No phone added' }}</small>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $appointment->pet->image_url }}" alt="{{ $appointment->pet->name }}" class="rounded-circle object-fit-cover" style="width: 40px; height: 40px;">
                                        <div>
                                            <h4 class="h6 fw-bold m-0 text-dark">{{ $appointment->pet->name }}</h4>
                                            <small class="text-muted">{{ $appointment->pet->breed ?? $appointment->pet->species }}</small>
                                        </div>
                                    </div>
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
                                    @if($appointment->isPending())
                                        <div class="d-flex justify-content-end gap-2">
                                            <form method="POST" action="{{ route('dashboard.appointments.vet-approve', $appointment) }}" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm fw-semibold px-3">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('dashboard.appointments.vet-reject', $appointment) }}" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold px-3">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($appointment->isApproved())
                                        <form method="POST" action="{{ route('dashboard.appointments.vet-complete', $appointment) }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm text-dark fw-semibold px-3">
                                                <i class="bi bi-check-circle me-1"></i> Mark Completed
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
