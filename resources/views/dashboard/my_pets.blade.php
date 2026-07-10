@extends('layouts.dashboard')

@section('title', 'My Pets | PetCareHub')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">My Adopted Pets</h1>
            <p class="text-secondary mb-0">Manage your beloved companions and check their care details.</p>
        </div>
        <a href="{{ route('pets.index') }}" class="btn btn-primary">
            <i class="bi bi-search-heart me-1"></i> Adopt Another Pet
        </a>
    </div>

    @if($pets->isNotEmpty())
        <div class="row g-4">
            @foreach($pets as $pet)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="content-card h-100 overflow-hidden shadow-sm d-flex flex-column border-light-subtle">
                        <div class="position-relative" style="height: 180px;">
                            @if(!empty($pet->image_url))
                                <img src="{{ $pet->image_url }}" alt="{{ $pet->name }}" class="w-100 h-100 object-fit-cover transition-scale">
                            @else
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center border-bottom">
                                    <i class="bi bi-image text-secondary fs-1"></i>
                                </div>
                            @endif
                            <div class="position-absolute top-0 right-0 p-2">
                                <span class="badge bg-success rounded-pill shadow-sm">Adopted</span>
                            </div>
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <h3 class="h6 fw-bold mb-1 text-dark">{{ $pet->name }}</h3>
                            <p class="small text-secondary mb-2">{{ $pet->breed }} ({{ $pet->species }})</p>
                            
                            <div class="row g-0 border-top pt-2 mt-auto mb-3 text-center small text-secondary">
                                <div class="col-6 border-end">
                                    <span class="d-block text-muted small uppercase" style="font-size: 0.65rem;">Age</span>
                                    <span class="fw-semibold text-dark">{{ $pet->age }} {{ Str::plural('year', $pet->age) }}</span>
                                </div>
                                <div class="col-6">
                                    <span class="d-block text-muted small uppercase" style="font-size: 0.65rem;">Gender</span>
                                    <span class="fw-semibold text-dark">{{ $pet->gender }}</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('pets.show', $pet->id) }}" class="btn btn-sm btn-outline-success w-100 rounded-pill">
                                View Profile & Health
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="content-card text-center p-5">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-heart-pulse text-secondary fs-2"></i>
            </div>
            <h2 class="h5 fw-bold text-dark mb-2">No Adopted Pets Yet</h2>
            <p class="text-secondary mx-auto mb-4" style="max-width: 400px;">
                You haven't adopted any pets yet! Once a shelter staff member approves your adoption application, your pet will show up here.
            </p>
            <a href="{{ route('pets.index') }}" class="btn btn-primary px-4">
                <i class="bi bi-search-heart me-1"></i> Browse Available Pets
            </a>
        </div>
    @endif
@endsection

<style>
    .transition-scale {
        transition: transform 0.3s ease;
    }
    .content-card:hover .transition-scale {
        transform: scale(1.05);
    }
</style>
