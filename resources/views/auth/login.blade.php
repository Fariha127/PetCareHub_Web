@extends('layouts.auth')

@section('title', 'Login | PetCareHub')
@section('nav', true)

@section('intro')
    <p class="eyebrow">Account Access</p>
    <h1 class="intro-title">Welcome back to PetCareHub</h1>
    <p class="intro-copy">
        Sign in to review adoptions, update pet records, and track shelter or veterinary activity.
    </p>

    <ul class="feature-list">
        <li>Secure role-based access</li>
        <li>Unified dashboard for pets and care</li>
        <li>Fast reporting for course demos</li>
    </ul>
@endsection

@section('content')
    <p class="eyebrow">Welcome Back</p>
    <h2 class="form-title">Login to PetCareHub</h2>

    <form method="POST" action="{{ route('login') }}" class="vstack gap-4">
        @csrf

        <div>
            <label for="email" class="form-label">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="name@example.com"
                required
                autofocus
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div>
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

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <p class="auth-note mb-0">
            Need an account?
            <a href="{{ route('register') }}" class="link-success">Register</a>
        </p>
    </form>
@endsection
