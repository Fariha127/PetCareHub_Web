@extends('layouts.dashboard')

@section('title', 'My Adoption Requests | PetCareHub')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">My Adoption Requests</h1>
            <p class="text-secondary mb-0">Review the status of your applications and shelter feedback.</p>
        </div>
        <a href="{{ route('pets.index') }}" class="btn btn-primary">
            <i class="bi bi-search-heart me-1"></i> Browse More Pets
        </a>
    </div>

    @forelse($applications as $app)
        <div class="content-card p-4 mb-3 border-start border-4 @if($app->isApproved()) border-success @elseif($app->isRejected()) border-danger @else border-warning @endif shadow-sm">
            <div class="row align-items-center g-3">
                <!-- Pet Image/Details column -->
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="d-flex align-items-center gap-3">
                        @if(!empty($app->pet->image_url))
                            <img src="{{ $app->pet->image_url }}" alt="{{ $app->pet->name }}" class="rounded-3 shadow-sm object-fit-cover" style="width: 70px; height: 70px;">
                        @else
                            <div class="rounded-3 bg-light d-flex align-items-center justify-content-center border" style="width: 70px; height: 70px;">
                                <i class="bi bi-tag text-secondary fs-3"></i>
                            </div>
                        @endif
                        <div>
                            <h3 class="h6 mb-1 fw-bold">
                                <a href="{{ route('pets.show', $app->pet_id) }}" class="text-decoration-none text-success">
                                    {{ $app->pet->name ?? 'Deleted Pet' }}
                                </a>
                            </h3>
                            <span class="badge bg-light text-secondary border rounded-pill py-1 px-2.5 small">{{ $app->pet->species ?? '-' }} • {{ $app->pet->breed ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status column -->
                <div class="col-6 col-md-3 text-start text-md-center">
                    <span class="small text-secondary d-block mb-1">Status</span>
                    @if($app->isApproved())
                        <span class="badge badge-approved rounded-pill px-3 py-1.5 fw-semibold">
                            <i class="bi bi-check-circle-fill me-1"></i> Approved
                        </span>
                    @elseif($app->isRejected())
                        <span class="badge badge-rejected rounded-pill px-3 py-1.5 fw-semibold">
                            <i class="bi bi-x-circle-fill me-1"></i> Rejected
                        </span>
                    @else
                        <span class="badge badge-pending rounded-pill px-3 py-1.5 fw-semibold">
                            <i class="bi bi-clock-history me-1"></i> Pending Review
                        </span>
                    @endif
                </div>

                <!-- Date column -->
                <div class="col-6 col-md-2 text-end text-md-center">
                    <span class="small text-secondary d-block mb-1">Applied On</span>
                    <span class="fw-semibold small text-dark">{{ $app->created_at->format('M d, Y') }}</span>
                </div>

                <!-- Action Button column -->
                <div class="col-12 col-md-3 text-end">
                    <a href="{{ route('pets.show', $app->pet_id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                        View Pet Profile <i class="bi bi-chevron-right ms-1 small"></i>
                    </a>
                </div>
            </div>

            <!-- Message & Notes Accordion/Detail section -->
            <div class="mt-3 pt-3 border-top bg-light-subtle rounded p-3">
                <div class="row g-3">
                    <div class="col-12 col-md-6 border-end-md">
                        <span class="small text-secondary fw-semibold d-block mb-1">Your Message:</span>
                        <p class="mb-0 small text-dark font-monospace italic">"{{ $app->message ?? 'No message provided.' }}"</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <span class="small text-secondary fw-semibold d-block mb-1">Shelter Feedback:</span>
                        @if(!empty($app->admin_notes))
                            <p class="mb-0 small text-dark fw-medium">
                                <i class="bi bi-chat-left-text me-1 text-success"></i> {{ $app->admin_notes }}
                            </p>
                            @if($app->reviewer)
                                <span class="small text-secondary d-block mt-1">Reviewed by: {{ $app->reviewer->name }}</span>
                            @endif
                        @else
                            <p class="mb-0 small text-secondary">
                                <i class="bi bi-hourglass me-1"></i> Our shelter staff will review your application soon.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="content-card text-center p-5">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-file-earmark-text text-secondary fs-2"></i>
            </div>
            <h2 class="h5 fw-bold text-dark mb-2">No Requests Yet</h2>
            <p class="text-secondary mx-auto mb-4" style="max-width: 400px;">
                You haven't submitted any adoption applications yet. Browse our lovely animals and apply to adopt one today!
            </p>
            <a href="{{ route('pets.index') }}" class="btn btn-primary px-4">
                <i class="bi bi-search-heart me-1"></i> Find a Companion
            </a>
        </div>
    @endforelse
@endsection
