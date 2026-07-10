@extends('layouts.dashboard')

@section('title', 'Add Pet | PetCareHub')

@section('content')
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="text-success text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="p-3 border-bottom">
                    <h1 class="h4 mb-0"><i class="bi bi-plus-circle me-1 text-success"></i> Add New Pet</h1>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('pets.store') }}">
                        @csrf

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Pet Name <span class="text-danger">*</span></label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="species" class="form-label">Species <span class="text-danger">*</span></label>
                                <input id="species" type="text" name="species" value="{{ old('species') }}" class="form-control @error('species') is-invalid @enderror" placeholder="e.g. Dog, Cat, Bird" required>
                                @error('species') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="breed" class="form-label">Breed</label>
                                <input id="breed" type="text" name="breed" value="{{ old('breed') }}" class="form-control" placeholder="e.g. Labrador, Persian">
                            </div>
                            <div class="col-md-3">
                                <label for="age" class="form-label">Age (years)</label>
                                <input id="age" type="number" name="age" value="{{ old('age') }}" class="form-control" min="0" max="100">
                            </div>
                            <div class="col-md-3">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                                    <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                                </select>
                                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="vaccination_status" class="form-label">Vaccination Status <span class="text-danger">*</span></label>
                                <select id="vaccination_status" name="vaccination_status" class="form-select" required>
                                    <option value="Not Vaccinated" @selected(old('vaccination_status') === 'Not Vaccinated')>Not Vaccinated</option>
                                    <option value="Vaccinated" @selected(old('vaccination_status') === 'Vaccinated')>Vaccinated</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="adoption_status" class="form-label">Adoption Status <span class="text-danger">*</span></label>
                                <select id="adoption_status" name="adoption_status" class="form-select" required>
                                    <option value="Available" @selected(old('adoption_status', 'Available') === 'Available')>Available</option>
                                    <option value="Adopted" @selected(old('adoption_status') === 'Adopted')>Adopted</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input id="image_url" type="url" name="image_url" value="{{ old('image_url') }}" class="form-control" placeholder="https://example.com/photo.jpg">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="3" class="form-control" placeholder="Describe the pet's personality, habits, etc.">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i> Save Pet
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
