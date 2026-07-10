@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

@section('title', $pet->name . ' | PetCareHub')

@section('content')
    @if(auth()->check())
        <a class="link-success d-inline-block mb-4" href="{{ route('pets.index') }}"><i class="bi bi-arrow-left"></i> Back to pets</a>
    @else
        <main class="page-section">
            <div class="container">
                <a class="link-success d-inline-block mb-4" href="{{ route('pets.index') }}">Back to pets</a>
    @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

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

                        {{-- Adoption application section --}}
                        @auth
                            @if(auth()->user()->isAdopter())
                                @if($existingApplication)
                                    <div class="alert {{ $existingApplication->status === 'approved' ? 'alert-success' : ($existingApplication->status === 'rejected' ? 'alert-danger' : 'alert-warning') }} mt-3 mb-0">
                                        <strong>Application Status:</strong> {{ ucfirst($existingApplication->status) }}
                                        @if($existingApplication->admin_notes)
                                            <br><small class="text-secondary">{{ $existingApplication->admin_notes }}</small>
                                        @endif
                                    </div>
                                @elseif($pet->adoption_status === 'Available')
                                    <div class="mt-3">
                                        <form method="POST" action="{{ route('applications.store', $pet->id) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="adopt-message" class="form-label fw-semibold">Why do you want to adopt {{ $pet->name }}?</label>
                                                <textarea id="adopt-message" name="message" rows="3" class="form-control" placeholder="Tell us about your home, experience with pets, and why you'd be a great match..."></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-heart-fill me-1" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                                </svg>
                                                Apply to Adopt {{ $pet->name }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="alert alert-secondary mt-3 mb-0">
                                        This pet has already been adopted.
                                    </div>
                                @endif
                            @elseif(auth()->user()->isShelterStaff())
                                <div class="mt-3">
                                    <a href="{{ route('pets.edit', $pet->id) }}" class="btn btn-outline-success w-100">
                                        <i class="bi bi-pencil-square me-1"></i> Edit This Pet
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info mt-3 mb-0">
                                <a href="{{ route('login') }}" class="alert-link">Login</a> or <a href="{{ route('register') }}" class="alert-link">Register</a> to apply for adoption.
                            </div>
                        @endauth
                    </div>
                </div>
            </article>

            {{-- Vet Checkup History --}}
            @if($checkups->isNotEmpty())
                <div class="content-card mt-4 p-4">
                    <h2 class="h5 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#198754" class="me-1" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.25-11.25v3h3a.75.75 0 0 1 0 1.5h-3v3a.75.75 0 0 1-1.5 0v-3h-3a.75.75 0 0 1 0-1.5h3v-3a.75.75 0 0 1 1.5 0"/>
                        </svg>
                        Veterinary Checkup History
                    </h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Veterinarian</th>
                                    <th>Diagnosis</th>
                                    <th>Treatment</th>
                                    <th>Weight</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkups as $checkup)
                                    <tr>
                                        <td>{{ $checkup->checkup_date->format('M d, Y') }}</td>
                                        <td>{{ $checkup->vet->name ?? '-' }}</td>
                                        <td>{{ $checkup->diagnosis ?? '-' }}</td>
                                        <td class="small">{{ Str::limit($checkup->treatment, 60) ?? '-' }}</td>
                                        <td>{{ $checkup->weight ? $checkup->weight . ' kg' : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        @if(!auth()->check())
            </div>
        </main>
        @endif

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
