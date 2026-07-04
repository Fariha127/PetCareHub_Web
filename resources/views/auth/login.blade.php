@extends('layouts.auth')

@section('title', 'Login | PetCareHub')
@section('nav', true)

@section('intro')
    <p class="eyebrow">Good to see you again</p>
    <h1 class="intro-title">Continue your journey toward the right companion.</h1>
    <p class="intro-copy">
        Pick up where you left off, revisit pets you care about, and keep your adoption plans organized in one calm, simple place.
    </p>

    <ul class="feature-list">
        <li>Explore pet profiles with clear care details</li>
        <li>Track availability before making a decision</li>
        <li>Keep your account ready for adoption requests</li>
    </ul>

    <span class="auth-chip">Trusted pet discovery starts here</span>

    <div class="auth-visual">
        <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=700&q=80" alt="Friendly dog">
        <img src="https://images.unsplash.com/photo-1574158622682-e40e69881006?auto=format&fit=crop&w=500&q=80" alt="Calm cat">
    </div>
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
