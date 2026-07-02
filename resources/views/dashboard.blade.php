@extends('layouts.auth')

@section('title', 'Dashboard | PetCareHub')
@section('subtitle', 'Role-based access ready')

@section('content')
    <div class="alert alert-success">
        Welcome, {{ auth()->user()->name }}. You are logged in as
        <strong>{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</strong>.
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger w-100">Logout</button>
    </form>
@endsection
