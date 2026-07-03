@extends('layouts.app')

@section('title', $pet->name . ' | PetCareHub')

@section('content')
    <main class="page-section">
        <div class="container">
            <a class="link-success d-inline-block mb-4" href="{{ route('pets.index') }}">Back to pets</a>

            <article class="content-card p-4 p-lg-5">
                <div class="row g-5 align-items-start">
                    <div class="col-lg-6">
                        <img class="pet-detail-image" src="{{ $pet->image_url }}" alt="{{ $pet->name }}">
                    </div>

                    <div class="col-lg-6">
                        <p class="eyebrow">Pet Details</p>
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                            <h1 class="section-title mb-0">{{ $pet->name }}</h1>
                            <span class="status-pill {{ $pet->adoption_status === 'Adopted' ? 'adopted' : '' }}">{{ $pet->adoption_status }}</span>
                        </div>

                        <p class="muted-copy mb-4">{{ $pet->description }}</p>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <tbody>
                                    <tr>
                                        <th scope="row">Species</th>
                                        <td>{{ $pet->species }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Breed</th>
                                        <td>{{ $pet->breed ?? 'Mixed / Unknown' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Age</th>
                                        <td>{{ $pet->age }} year{{ $pet->age === 1 ? '' : 's' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Gender</th>
                                        <td>{{ $pet->gender }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Vaccination status</th>
                                        <td>{{ $pet->vaccination_status }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Adoption status</th>
                                        <td>{{ $pet->adoption_status }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-success mt-4 mb-0">
                            This page is read-only for guests, users, shelter staff, and veterinarians.
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </main>
@endsection
