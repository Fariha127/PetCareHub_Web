@extends('layouts.auth')

@section('title', 'Register | PetCareHub')
@section('nav', true)

@section('intro')
    <p class="eyebrow">New Account</p>
    <h1 class="intro-title">Join the PetCareHub workspace</h1>
    <p class="intro-copy">
        Create an adopter account to request adoptions and book veterinary appointments.
    </p>

    <p class="auth-note mt-4 mb-0">
        Already registered?
        <a href="{{ route('login') }}" class="link-success">Login here.</a>
    </p>
@endsection

@section('content')
    <p class="eyebrow">Create Account</p>
    <h2 class="form-title">Register for PetCareHub</h2>

    <form method="POST" action="{{ route('register') }}" class="vstack gap-4">
        @csrf
        <input type="hidden" name="role" value="adopter">

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
                <label for="phone" class="form-label">Phone</label>
                <input
                    id="phone"
                    type="tel"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="form-control"
                    placeholder="Phone number"
                >
            </div>
        </div>

        <div>
            <label for="address" class="form-label">Address</label>
            <input
                id="address"
                type="text"
                name="address"
                value="{{ old('address') }}"
                class="form-control"
                placeholder="Street, city"
            >
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
