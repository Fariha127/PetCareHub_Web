@extends('layouts.dashboard')

@section('title', 'Vet Dashboard | PetCareHub')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Veterinarian Dashboard</h1>
            <p class="text-secondary mb-0">Record checkups and monitor pet health.</p>
        </div>
    </div>

    <!-- Stat cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #e9f7ef; color: #198754;">
                    <i class="bi bi-clipboard2-pulse"></i>
                </div>
                <div class="stat-value">{{ $totalCheckups }}</div>
                <div class="stat-label">Checkups Completed</div>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #fff3cd; color: #856404;">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div class="stat-value">{{ $upcomingCount }}</div>
                <div class="stat-label">Upcoming Checkups</div>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #cfe2ff; color: #084298;">
                    <i class="bi bi-heart-pulse"></i>
                </div>
                <div class="stat-value">{{ $pets->count() }}</div>
                <div class="stat-label">Registered Pets</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Add Checkup Form -->
        <div class="col-lg-5">
            <div class="content-card">
                <div class="p-3 border-bottom">
                    <h2 class="h5 mb-0"><i class="bi bi-plus-circle me-1 text-success"></i> New Checkup</h2>
                </div>
                <div class="p-3">
                    <form method="POST" action="{{ route('checkups.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="pet_id" class="form-label">Pet <span class="text-danger">*</span></label>
                            <select id="pet_id" name="pet_id" class="form-select @error('pet_id') is-invalid @enderror" required>
                                <option value="">Select a pet...</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}" @selected(old('pet_id') == $pet->id)>
                                        {{ $pet->name }} ({{ $pet->species }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pet_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="checkup_date" class="form-label">Checkup Date <span class="text-danger">*</span></label>
                            <input id="checkup_date" type="date" name="checkup_date" value="{{ old('checkup_date', now()->toDateString()) }}" class="form-control @error('checkup_date') is-invalid @enderror" required>
                            @error('checkup_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="weight" class="form-label">Weight (kg)</label>
                                <input id="weight" type="number" step="0.01" name="weight" value="{{ old('weight') }}" class="form-control" placeholder="e.g. 4.5">
                            </div>
                            <div class="col-6">
                                <label for="temperature" class="form-label">Temp (°C)</label>
                                <input id="temperature" type="number" step="0.1" name="temperature" value="{{ old('temperature') }}" class="form-control" placeholder="e.g. 38.5">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <input id="diagnosis" type="text" name="diagnosis" value="{{ old('diagnosis') }}" class="form-control" placeholder="Brief diagnosis">
                        </div>

                        <div class="mb-3">
                            <label for="treatment" class="form-label">Treatment</label>
                            <textarea id="treatment" name="treatment" rows="2" class="form-control" placeholder="Treatment details">{{ old('treatment') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="next_checkup_date" class="form-label">Next Checkup Date</label>
                            <input id="next_checkup_date" type="date" name="next_checkup_date" value="{{ old('next_checkup_date') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea id="notes" name="notes" rows="2" class="form-control" placeholder="Additional notes">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i> Save Checkup
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Recent checkups table -->
        <div class="col-lg-7">
            <div class="content-card">
                <div class="p-3 border-bottom">
                    <h2 class="h5 mb-0">Recent Checkups</h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Pet</th>
                                <th>Date</th>
                                <th>Diagnosis</th>
                                <th>Weight</th>
                                <th>Next</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($checkups as $checkup)
                                <tr>
                                    <td>
                                        <a href="{{ route('pets.show', $checkup->pet_id) }}" class="text-decoration-none text-success fw-semibold">
                                            {{ $checkup->pet->name ?? 'N/A' }}
                                        </a>
                                        <span class="text-secondary small d-block">{{ $checkup->pet->species ?? '' }}</span>
                                    </td>
                                    <td class="small">{{ $checkup->checkup_date->format('M d, Y') }}</td>
                                    <td class="small text-secondary">{{ Str::limit($checkup->diagnosis, 40) ?? '-' }}</td>
                                    <td class="small">{{ $checkup->weight ? $checkup->weight . ' kg' : '-' }}</td>
                                    <td class="small">
                                        @if($checkup->next_checkup_date)
                                            <span class="{{ $checkup->next_checkup_date->isPast() ? 'text-danger' : 'text-success' }}">
                                                {{ $checkup->next_checkup_date->format('M d, Y') }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-secondary py-4">
                                        No checkups recorded yet. Use the form to add your first checkup.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Upcoming checkups -->
            @if($upcomingCheckups->isNotEmpty())
                <div class="content-card mt-4">
                    <div class="p-3 border-bottom">
                        <h2 class="h5 mb-0"><i class="bi bi-calendar-event me-1 text-warning"></i> Upcoming Checkups</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Pet</th>
                                    <th>Scheduled Date</th>
                                    <th>Last Diagnosis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingCheckups as $upcoming)
                                    <tr>
                                        <td class="fw-semibold">{{ $upcoming->pet->name ?? 'N/A' }}</td>
                                        <td>{{ $upcoming->next_checkup_date->format('M d, Y') }}</td>
                                        <td class="small text-secondary">{{ $upcoming->diagnosis ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
