@extends('layouts.dashboard')

@section('title', 'Event Participants | PetCareHub')

@section('content')
    <div class="mb-4">
        <a href="{{ route('events.index') }}" class="btn btn-link text-decoration-none p-0 text-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Back to Events
        </a>
        <h1 class="page-title mb-1">Participants for "{{ $event->title }}"</h1>
        <p class="text-secondary mb-0">Inspect the users who are going or interested in this event.</p>
    </div>

    <div class="row g-4">
        <!-- Going List -->
        <div class="col-md-6">
            <div class="content-card p-4">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                    <h2 class="h5 fw-bold mb-0 text-success">
                        <i class="bi bi-check-circle-fill me-2"></i>Going ({{ $going->count() }})
                    </h2>
                </div>
                
                @if($going->isNotEmpty())
                    <div class="list-group list-group-flush">
                        @foreach($going as $participation)
                            @php $user = $participation->user; @endphp
                            <div class="list-group-item px-0 py-3">
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div>
                                        <h3 class="h6 fw-semibold text-dark mb-1">
                                            <a href="{{ route('dashboard.users.show', $user) }}" class="text-decoration-none text-primary">
                                                {{ $user->name }}
                                            </a>
                                        </h3>
                                        <p class="text-secondary small mb-0">
                                            <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                                            @if($user->phone)
                                                <span class="mx-2">•</span><i class="bi bi-telephone me-1"></i>{{ $user->phone }}
                                            @endif
                                        </p>
                                    </div>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small">Going</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-secondary">
                        <i class="bi bi-people" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0 small">No one has responded 'Going' yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Interested List -->
        <div class="col-md-6">
            <div class="content-card p-4">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                    <h2 class="h5 fw-bold mb-0 text-warning">
                        <i class="bi bi-star-fill me-2"></i>Interested ({{ $interested->count() }})
                    </h2>
                </div>
                
                @if($interested->isNotEmpty())
                    <div class="list-group list-group-flush">
                        @foreach($interested as $participation)
                            @php $user = $participation->user; @endphp
                            <div class="list-group-item px-0 py-3">
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div>
                                        <h3 class="h6 fw-semibold text-dark mb-1">
                                            <a href="{{ route('dashboard.users.show', $user) }}" class="text-decoration-none text-primary">
                                                {{ $user->name }}
                                            </a>
                                        </h3>
                                        <p class="text-secondary small mb-0">
                                            <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                                            @if($user->phone)
                                                <span class="mx-2">•</span><i class="bi bi-telephone me-1"></i>{{ $user->phone }}
                                            @endif
                                        </p>
                                    </div>
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2.5 py-1 small text-dark">Interested</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-secondary">
                        <i class="bi bi-people" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0 small">No one has responded 'Interested' yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
