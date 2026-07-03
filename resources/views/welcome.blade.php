@extends('layouts.app')

@section('title', 'Home | PetCareHub')

@section('content')
    <main>
        <section class="page-section">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <p class="eyebrow">Pet Adoption & Veterinary Care</p>
                        <h1 class="hero-title mb-4">Find pets and follow their care journey.</h1>
                        <p class="muted-copy mb-4">
                            PetCareHub gives guests, adopters, shelter staff, and veterinarians a shared read-only view of pets available in the system.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-primary btn-lg" href="{{ route('pets.index') }}">View pets</a>
                            @guest
                                <a class="btn btn-outline-success btn-lg" href="{{ route('register') }}">Register</a>
                            @endguest
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="content-card p-4 p-lg-5">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="border rounded-3 p-4 h-100">
                                        <h2 class="h5">Guests</h2>
                                        <p class="text-secondary mb-0">Browse the pet catalog and open pet details.</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="border rounded-3 p-4 h-100">
                                        <h2 class="h5">Users</h2>
                                        <p class="text-secondary mb-0">Review pet profiles before adoption requests are added.</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="border rounded-3 p-4 h-100">
                                        <h2 class="h5">Shelter Staff</h2>
                                        <p class="text-secondary mb-0">Check public pet information from the same catalog.</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="border rounded-3 p-4 h-100">
                                        <h2 class="h5">Veterinarians</h2>
                                        <p class="text-secondary mb-0">View pet identity, vaccination, and availability status.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-section pt-0">
            <div class="container">
                <div class="content-card p-4 p-lg-5">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <p class="eyebrow">Read Only Access</p>
                            <h2 class="section-title mb-3">Every role can view pets and pet details.</h2>
                            <p class="muted-copy mb-0">
                                Management actions such as adding, editing, deleting, appointments, and adoption approvals can be introduced later behind role-based dashboards.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a class="btn btn-primary btn-lg" href="{{ route('pets.index') }}">Open pet listing</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
