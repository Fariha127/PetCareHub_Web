@extends('layouts.dashboard')

@section('title', 'Edit ' . $pet->name . ' | PetCareHub')

@section('content')
    <div class="mb-4">
        <a href="{{ route('pets.show', $pet) }}" class="text-success text-decoration-none"><i class="bi bi-arrow-left"></i> Back to {{ $pet->name }}</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                    <h1 class="h4 mb-0"><i class="bi bi-pencil-square me-1 text-success"></i> Edit Pet: {{ $pet->name }}</h1>
                    <form method="POST" action="{{ route('pets.destroy', $pet) }}" onsubmit="return confirm('Are you sure you want to delete this pet?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('pets.update', $pet) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Pet Name <span class="text-danger">*</span></label>
                                <input id="name" type="text" name="name" value="{{ old('name', $pet->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="species" class="form-label">Species <span class="text-danger">*</span></label>
                                <input id="species" type="text" name="species" value="{{ old('species', $pet->species) }}" class="form-control @error('species') is-invalid @enderror" required>
                                @error('species') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="breed" class="form-label">Breed</label>
                                <input id="breed" type="text" name="breed" value="{{ old('breed', $pet->breed) }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="age" class="form-label">Age (years)</label>
                                <input id="age" type="number" name="age" value="{{ old('age', $pet->age) }}" class="form-control" min="0" max="100">
                            </div>
                            <div class="col-md-3">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select id="gender" name="gender" class="form-select" required>
                                    <option value="Male" @selected(old('gender', $pet->gender) === 'Male')>Male</option>
                                    <option value="Female" @selected(old('gender', $pet->gender) === 'Female')>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="vaccination_status" class="form-label">Vaccination Status <span class="text-danger">*</span></label>
                                <select id="vaccination_status" name="vaccination_status" class="form-select" required>
                                    <option value="Not Vaccinated" @selected(old('vaccination_status', $pet->vaccination_status) === 'Not Vaccinated')>Not Vaccinated</option>
                                    <option value="Vaccinated" @selected(old('vaccination_status', $pet->vaccination_status) === 'Vaccinated')>Vaccinated</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="adoption_status" class="form-label">Adoption Status <span class="text-danger">*</span></label>
                                <select id="adoption_status" name="adoption_status" class="form-select" required>
                                    <option value="Available" @selected(old('adoption_status', $pet->adoption_status) === 'Available')>Available</option>
                                    <option value="Adopted" @selected(old('adoption_status', $pet->adoption_status) === 'Adopted')>Adopted</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input id="image_url" type="url" name="image_url" value="{{ old('image_url', $pet->image_url) }}" class="form-control">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="3" class="form-control">{{ old('description', $pet->description) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i> Update Pet
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
