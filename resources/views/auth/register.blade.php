@extends('layouts.auth')

@section('title', 'Register | PetCareHub')
@section('nav', true)

@section('intro')
    <p class="eyebrow">Start your adoption journey</p>
    <h1 class="intro-title">Create a home for the pet who is waiting for you.</h1>
    <p class="intro-copy">
        Build your PetCareHub account to discover adoptable pets, save your details, and move faster when you find the right match.
    </p>

    <ul class="feature-list">
        <li>Browse pets by species, breed, age, and care status</li>
        <li>Review each pet's story before taking the next step</li>
        <li>Keep your contact details ready for future adoption requests</li>
    </ul>

    <p class="auth-note mt-4 mb-0">
        Already registered?
        <a href="{{ route('login') }}" class="link-success">Login here.</a>
    </p>

    <div class="auth-visual">
        <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?auto=format&fit=crop&w=700&q=80" alt="Pets together">
        <img src="https://images.unsplash.com/photo-1522926193341-e9ffd686c60f?auto=format&fit=crop&w=500&q=80" alt="Small bird">
    </div>
@endsection

@section('content')
    <p class="eyebrow">Create Account</p>
    <h2 class="form-title">Register for PetCareHub</h2>

    <form method="POST" action="{{ route('register') }}" class="vstack gap-4">
        @csrf

        <div>
            <label for="name" class="form-label">Full Name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Your name"
                required
                autofocus
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="name@example.com"
                    required
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="role" class="form-label">I am a</label>
                <select
                    id="role"
                    name="role"
                    class="form-select @error('role') is-invalid @enderror"
                    required
                >
                    <option value="adopter" @selected(old('role', 'adopter') === 'adopter')>Pet Adopter</option>
                    <option value="shelter_staff" @selected(old('role') === 'shelter_staff')>Shelter Staff</option>
                    <option value="veterinarian" @selected(old('role') === 'veterinarian')>Veterinarian</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
            <label for="password" class="form-label">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Password"
                required
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>

            <div class="col-md-6">
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Confirm password"
                required
            >
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
@endsection
