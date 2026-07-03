@extends('layouts.app')

@section('title', 'Pets | PetCareHub')

@section('content')
    <main class="page-section">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row align-items-lg-end justify-content-between gap-3 mb-4">
                <div>
                    <p class="eyebrow">Pet Listing</p>
                    <h1 class="section-title mb-2">Browse pets</h1>
                    <p class="muted-copy mb-0">Available to guests, users, shelter staff, and veterinarians.</p>
                </div>
            </div>

            <form method="GET" action="{{ route('pets.index') }}" class="content-card p-4 mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5">
                        <label for="search" class="form-label">Search</label>
                        <input id="search" name="search" type="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="Pet name, species, or breed">
                    </div>
                    <div class="col-lg-3">
                        <label for="species" class="form-label">Species</label>
                        <select id="species" name="species" class="form-select">
                            <option value="">All species</option>
                            @foreach ($speciesOptions as $species)
                                <option value="{{ $species }}" @selected(($filters['species'] ?? '') === $species)>{{ $species }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="availability" class="form-label">Availability</label>
                        <select id="availability" name="availability" class="form-select">
                            <option value="">All statuses</option>
                            <option value="Available" @selected(($filters['availability'] ?? '') === 'Available')>Available</option>
                            <option value="Adopted" @selected(($filters['availability'] ?? '') === 'Adopted')>Adopted</option>
                        </select>
                    </div>
                    <div class="col-lg-1 d-grid">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <div class="row g-4">
                @forelse ($pets as $pet)
                    <div class="col-md-6 col-xl-3">
                        <article class="pet-card h-100 overflow-hidden">
                            <img class="pet-image" src="{{ $pet->image_url }}" alt="{{ $pet->name }}">
                            <div class="p-4">
                                <div class="d-flex justify-content-between gap-3 mb-2">
                                    <h2 class="h4 mb-0">{{ $pet->name }}</h2>
                                    <span class="status-pill {{ $pet->adoption_status === 'Adopted' ? 'adopted' : '' }}">{{ $pet->adoption_status }}</span>
                                </div>
                                <p class="text-secondary mb-3">{{ $pet->species }} @if($pet->breed) / {{ $pet->breed }} @endif</p>
                                <dl class="row small text-secondary mb-4">
                                    <dt class="col-5">Age</dt>
                                    <dd class="col-7">{{ $pet->age }} year{{ $pet->age === 1 ? '' : 's' }}</dd>
                                    <dt class="col-5">Gender</dt>
                                    <dd class="col-7">{{ $pet->gender }}</dd>
                                    <dt class="col-5">Vaccine</dt>
                                    <dd class="col-7">{{ $pet->vaccination_status }}</dd>
                                </dl>
                                <a class="btn btn-outline-success w-100" href="{{ route('pets.show', $pet->id) }}">View details</a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="content-card p-5 text-center">
                            <h2 class="h4">No pets found</h2>
                            <p class="text-secondary mb-0">Try changing the search or filter values.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection
