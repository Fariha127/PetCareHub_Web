@extends('layouts.dashboard')

@section('title', 'My Events | PetCareHub')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">My Events</h1>
            <p class="text-secondary mb-0">Browse and manage the shelter events you have signed up for.</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="bi bi-calendar-event me-1"></i> Find More Events
        </a>
    </div>


    @if($participations->isNotEmpty())
        <div class="row g-4">
            @foreach($participations as $participation)
                @php $event = $participation->event; @endphp
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="content-card h-100 overflow-hidden shadow-sm d-flex flex-column border-light-subtle">
                        <div class="position-relative" style="height: 160px;">
                            @if(!empty($event->image_url))
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center border-bottom">
                                    <i class="bi bi-calendar-event text-secondary fs-1"></i>
                                </div>
                            @endif
                            <div class="position-absolute top-0 right-0 p-2">
                                @if($participation->status === 'going')
                                    <span class="badge bg-success rounded-pill shadow-sm">Going</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill shadow-sm">Interested</span>
                                @endif
                            </div>
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <span class="text-success small fw-semibold mb-1 d-block">
                                <i class="bi bi-calendar-date"></i> {{ $event->event_date->format('M d, Y @ h:i A') }}
                            </span>
                            <h3 class="h6 fw-bold mb-2 text-dark">{{ $event->title }}</h3>
                            <p class="small text-secondary mb-3 flex-grow-1">{{ Str::limit($event->description, 100) }}</p>
                            
                            <div class="border-top pt-2 mt-auto">
                                <div class="d-flex align-items-center justify-content-between mb-3 text-secondary small">
                                    <span><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $event->location }}</span>
                                </div>
                                
                                <form method="POST" action="{{ route('events.respond', $event) }}" class="d-flex gap-2">
                                    @csrf
                                    @if($participation->status === 'going')
                                        <button type="submit" name="status" value="interested" class="btn btn-sm btn-outline-warning text-dark w-100 rounded-pill">
                                            Change to Interested
                                        </button>
                                    @else
                                        <button type="submit" name="status" value="going" class="btn btn-sm btn-outline-success w-100 rounded-pill">
                                            Change to Going
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="content-card text-center p-5">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-calendar-x text-secondary fs-2"></i>
            </div>
            <h2 class="h5 fw-bold text-dark mb-2">No Enrolled Events</h2>
            <p class="text-secondary mx-auto mb-4" style="max-width: 400px;">
                You haven't responded to any upcoming shelter events yet. Check out the homepage to join campaigns, street feeding events, and support pet adoptions!
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary px-4">
                <i class="bi bi-calendar-event me-1"></i> View Shelter Events
            </a>
        </div>
    @endif
@endsection
