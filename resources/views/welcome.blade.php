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
    </main>
@endsection
