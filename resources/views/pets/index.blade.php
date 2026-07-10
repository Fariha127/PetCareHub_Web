@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

@section('title', 'Pets | PetCareHub')

@section('content')
    @if(auth()->check())
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="page-title mb-1">Browse Pets</h1>
                <p class="text-secondary mb-0">Search, filter, and sort available pets.</p>
            </div>
            @if(auth()->user()->isShelterStaff())
                <a href="{{ route('pets.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add Pet
                </a>
            @endif
        </div>
    @else
        <main class="page-section">
            <div class="container">
                <div class="d-flex flex-column flex-lg-row align-items-lg-end justify-content-between gap-3 mb-4">
                    <div>
                        <p class="eyebrow">Pet Listing</p>
                        <h1 class="section-title mb-0">Search, filter, and sort available pets</h1>
                    </div>
                </div>
    @endif

            <form method="GET" action="{{ route('pets.index') }}" class="pet-search mb-4">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6 col-xl-3">
                        <label for="search" class="visually-hidden">Search</label>
                        <input id="search" name="search" type="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="Search by name, breed, species">
                    </div>
                    <div class="col-md-6 col-xl-2">
                        <label for="species" class="visually-hidden">Species</label>
                        <select id="species" name="species" class="form-select">
                            <option value="">Species</option>
                            @foreach ($speciesOptions as $species)
                                <option value="{{ $species }}" @selected(($filters['species'] ?? '') === $species)>{{ $species }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xl-2">
                        <label for="breed" class="visually-hidden">Breed</label>
                        <select id="breed" name="breed" class="form-select">
                            <option value="">Breed</option>
                            @foreach ($breedOptions as $breed)
                                <option value="{{ $breed }}" @selected(($filters['breed'] ?? '') === $breed)>{{ $breed }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xl-1">
                        <label for="age" class="visually-hidden">Age</label>
                        <input id="age" name="age" type="number" min="0" class="form-control" value="{{ $filters['age'] ?? '' }}" placeholder="Age">
                    </div>
                    <div class="col-md-6 col-xl-2">
                        <label for="vaccination" class="visually-hidden">Vaccination</label>
                        <select id="vaccination" name="vaccination" class="form-select">
                            <option value="">Vaccination</option>
                            <option value="Vaccinated" @selected(($filters['vaccination'] ?? '') === 'Vaccinated')>Vaccinated</option>
                            <option value="Not Vaccinated" @selected(($filters['vaccination'] ?? '') === 'Not Vaccinated')>Not Vaccinated</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xl-2">
                        <label for="adoption_status" class="visually-hidden">Adoption Status</label>
                        <select id="adoption_status" name="adoption_status" class="form-select">
                            <option value="">Adoption Status</option>
                            <option value="Available" @selected(($filters['adoption_status'] ?? '') === 'Available')>Available</option>
                            <option value="Adopted" @selected(($filters['adoption_status'] ?? '') === 'Adopted')>Adopted</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xl-2">
                        <label for="sort" class="visually-hidden">Sort</label>
                        <select id="sort" name="sort" class="form-select">
                            <option value="newest" @selected(($filters['sort'] ?? 'newest') === 'newest')>Newest</option>
                            <option value="age_asc" @selected(($filters['sort'] ?? '') === 'age_asc')>Age: Youngest</option>
                            <option value="age_desc" @selected(($filters['sort'] ?? '') === 'age_desc')>Age: Oldest</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-xl-2 d-grid">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
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
    @if(!auth()->check())
            </div>
        </main>
    @endif
@endsection
