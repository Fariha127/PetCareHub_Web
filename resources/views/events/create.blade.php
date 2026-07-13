@extends('layouts.dashboard')

@section('title', 'Create Event | PetCareHub')

@section('content')
    <div class="mb-4">
        <a href="{{ route('events.index') }}" class="btn btn-link text-decoration-none p-0 text-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Back to Events
        </a>
        <h1 class="page-title mb-1">Create Event & Campaign</h1>
        <p class="text-secondary mb-0">Publish a new event, street feeding program, or donation campaign.</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="content-card p-4">
                <form method="POST" action="{{ route('events.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label text-dark fw-semibold">Event Title / Campaign Name</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Street Dogs Feeding Campaign" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="event_date" class="form-label text-dark fw-semibold">Date & Time</label>
                            <input type="datetime-local" class="form-control @error('event_date') is-invalid @enderror" id="event_date" name="event_date" value="{{ old('event_date') }}" required>
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label text-dark fw-semibold">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" placeholder="e.g. Central City Park" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image_url" class="form-label text-dark fw-semibold">Image URL (Optional)</label>
                        <input type="url" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="e.g. https://images.unsplash.com/photo-...">
                        @error('image_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label text-dark fw-semibold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" placeholder="Provide full details about the campaign, objectives, schedule, and volunteer/donation requirements..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-3 border-top pt-3">
                        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Publish Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
