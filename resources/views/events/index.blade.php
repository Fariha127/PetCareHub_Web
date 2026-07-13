@extends('layouts.dashboard')

@section('title', 'Manage Events | PetCareHub')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Manage Events & Campaigns</h1>
            <p class="text-secondary mb-0">Create, edit, and monitor public events and donation drives.</p>
        </div>
        <a href="{{ route('events.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Create Event
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="content-card overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="min-width: 200px;">Event / Campaign</th>
                        <th scope="col">Date & Time</th>
                        <th scope="col">Location</th>
                        <th scope="col">Creator</th>
                        <th scope="col" class="text-center">Responses</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($event->image_url)
                                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="rounded object-fit-cover" style="width: 48px; height: 48px;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 48px; height: 48px;">
                                            <i class="bi bi-calendar-event text-secondary"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h2 class="h6 fw-semibold text-dark mb-0">{{ $event->title }}</h2>
                                        <p class="text-muted small mb-0">{{ Str::limit($event->description, 60) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-medium text-dark">{{ $event->event_date->format('M d, Y') }}</span>
                                <span class="d-block small text-secondary">{{ $event->event_date->format('h:i A') }}</span>
                            </td>
                            <td>
                                <i class="bi bi-geo-alt text-danger me-1"></i>{{ $event->location }}
                            </td>
                            <td class="text-secondary small">
                                {{ $event->creator->name ?? 'System' }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <div class="text-center">
                                        <span class="badge bg-success rounded-pill px-2.5">{{ $event->going_count }}</span>
                                        <span class="d-block small text-muted mt-1" style="font-size: 0.7rem;">Going</span>
                                    </div>
                                    <div class="text-center">
                                        <span class="badge bg-warning text-dark rounded-pill px-2.5">{{ $event->interested_count }}</span>
                                        <span class="d-block small text-muted mt-1" style="font-size: 0.7rem;">Interested</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('events.participants', $event) }}" class="btn btn-sm btn-outline-primary" title="View Participants">
                                        <i class="bi bi-people-fill me-1"></i> Participants
                                    </a>
                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-outline-success" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Are you sure you want to delete this event?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                <i class="bi bi-calendar-x" style="font-size: 2.5rem;"></i>
                                <p class="mt-3 mb-0">No events or campaigns scheduled. Click "Create Event" to get started.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
