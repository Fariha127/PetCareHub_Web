@extends('layouts.app')

@section('title', 'Home | PetCareHub')

@section('content')
    <main>
        <section class="page-section">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <p class="eyebrow">Pet Adoption & Veterinary Care</p>
                        <h1 class="hero-title mb-4">Meet the pets waiting for a safer, happier home.</h1>
                        <p class="muted-copy mb-4">
                            Browse verified pet profiles, check vaccination and adoption status, and explore each animal's story before taking the next step.
                        </p>
                        <div class="d-flex flex-wrap gap-3 mb-5">
                            <a class="btn btn-primary btn-lg px-4" href="{{ route('pets.index') }}">Explore pets</a>
                            @guest
                                <a class="btn btn-outline-success btn-lg px-4" href="{{ route('register') }}">Create account</a>
                            @endguest
                        </div>

                        <div class="stat-grid">
                            <div class="stat-item">
                                <div class="stat-value">{{ $availablePetsCount }}</div>
                                <div class="text-secondary mt-2">pets ready to be adopted</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $adoptedPetsCount }}</div>
                                <div class="text-secondary mt-2">happy adoption stories started</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">24/7</div>
                                <div class="text-secondary mt-2">catalog access for visitors</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-media">
                            <img
                                class="hero-photo"
                                src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?auto=format&fit=crop&w=1200&q=80"
                                alt="Adoptable pets resting together"
                            >
                            <div class="floating-panel">
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div>
                                        <p class="eyebrow mb-1">Featured Status</p>
                                        <h2 class="h4 mb-1">Vaccinated pets available now</h2>
                                        <p class="text-secondary mb-0">Filter by species, breed, age, vaccination, and adoption status.</p>
                                    </div>
                                    <a class="btn btn-primary" href="{{ route('pets.index') }}">Search</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-section pt-0">
            <div class="container">
                <div class="content-card p-4 p-lg-5">
                    <div class="row g-4 align-items-end mb-4">
                        <div class="col-lg-8">
                            <p class="eyebrow">Why PetCareHub</p>
                            <h2 class="section-title mb-0">A simple place to discover pets with the details that matter.</h2>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a class="btn btn-outline-success btn-lg" href="{{ route('pets.index') }}">View pet listing</a>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="feature-tile">
                                <span class="feature-icon">01</span>
                                <h3 class="h5">Clear adoption status</h3>
                                <p class="text-secondary mb-0">Visitors can quickly see whether a pet is available or already adopted.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-tile">
                                <span class="feature-icon">02</span>
                                <h3 class="h5">Care information upfront</h3>
                                <p class="text-secondary mb-0">Vaccination, age, breed, gender, and notes are organized on each pet profile.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-tile">
                                <span class="feature-icon">03</span>
                                <h3 class="h5">Simple pet discovery</h3>
                                <p class="text-secondary mb-0">Explore profiles at your own pace and open details before choosing the right companion.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-section pt-0">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-5">
                        <p class="eyebrow">Browse with confidence</p>
                        <h2 class="section-title mb-3">Start with pets that match your home and care expectations.</h2>
                        <p class="muted-copy mb-4">
                            Use search and filters to narrow the catalog by species, breed, age, vaccination status, and adoption availability.
                        </p>
                        <a class="btn btn-primary btn-lg" href="{{ route('pets.index') }}">Find a pet</a>
                    </div>
                    <div class="col-lg-7">
                        <div class="pet-preview">
                            <img src="https://images.unsplash.com/photo-1574158622682-e40e69881006?auto=format&fit=crop&w=600&q=80" alt="Cat available for adoption">
                            <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=600&q=80" alt="Dog available for adoption">
                            <img src="https://images.unsplash.com/photo-1522926193341-e9ffd686c60f?auto=format&fit=crop&w=600&q=80" alt="Bird available for adoption">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Events & Campaigns Section -->
        <section class="page-section pt-0">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <p class="eyebrow mb-1">Get Involved</p>
                        <h2 class="section-title mb-0">Upcoming Events & Campaigns</h2>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row g-4">
                    @forelse($upcomingEvents as $event)
                        <div class="col-md-6 col-lg-4">
                            <div class="content-card h-100 d-flex flex-column overflow-hidden shadow-sm border-light">
                                @if($event->image_url)
                                    <img src="{{ $event->image_url }}" alt="{{ $event->title }}" style="height: 180px; object-fit: cover; width: 100%;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px; width: 100%;">
                                        <i class="bi bi-calendar-event text-secondary" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                                <div class="p-4 d-flex flex-column flex-grow-1">
                                    <span class="badge bg-success-subtle text-success border border-success-subtle align-self-start mb-2 px-2.5 py-1 rounded small">
                                        <i class="bi bi-calendar-date me-1"></i> {{ $event->event_date->format('M d, Y @ h:i A') }}
                                    </span>
                                    <h3 class="h5 fw-bold text-dark mb-2">{{ $event->title }}</h3>
                                    <p class="text-secondary small mb-3 flex-grow-1">{{ Str::limit($event->description, 140) }}</p>
                                    
                                    <div class="d-flex align-items-center gap-2 mb-3 text-secondary small">
                                        <i class="bi bi-geo-alt-fill text-danger"></i> <span>{{ $event->location }}</span>
                                    </div>

                                    <div class="border-top pt-3 mt-auto">
                                        <div class="d-flex align-items-center justify-content-between mb-3 text-secondary small">
                                            <span><strong>{{ $event->going_count }}</strong> Going</span>
                                            <span><strong>{{ $event->interested_count }}</strong> Interested</span>
                                        </div>

                                        @auth
                                            @if(auth()->user()->isAdopter())
                                                @php
                                                    $userParticipation = $event->participations->where('user_id', auth()->id())->first();
                                                @endphp
                                                <form method="POST" action="{{ route('events.respond', $event) }}" class="d-flex gap-2">
                                                    @csrf
                                                    <button type="submit" name="status" value="interested" class="btn btn-sm flex-fill {{ $userParticipation && $userParticipation->status === 'interested' ? 'btn-warning text-dark fw-bold' : 'btn-outline-warning text-dark' }}">
                                                        <i class="bi bi-star"></i> Interested
                                                    </button>
                                                    <button type="submit" name="status" value="going" class="btn btn-sm flex-fill {{ $userParticipation && $userParticipation->status === 'going' ? 'btn-success fw-bold' : 'btn-outline-success' }}">
                                                        <i class="bi bi-check-circle"></i> Going
                                                    </button>
                                                </form>
                                            @else
                                                <div class="text-center text-secondary small py-2 bg-light rounded border border-light">
                                                    Logged in as {{ auth()->user()->role_display }}
                                                </div>
                                            @endif
                                        @else
                                            <div class="alert alert-secondary py-2 px-3 mb-0 text-center small rounded border border-light">
                                                <a href="{{ route('login') }}" class="alert-link text-decoration-none text-success fw-semibold">Login</a> to respond to this event
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5 text-secondary border rounded-3 bg-light">
                                <i class="bi bi-calendar-x" style="font-size: 3rem;"></i>
                                <p class="mt-3 mb-0">No upcoming shelter events scheduled at the moment.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
@endsection
