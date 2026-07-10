@extends('layouts.dashboard')

@section('title', 'Monthly Adoption Report | PetCareHub')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">Monthly Adoption Report</h1>
            <p class="text-secondary mb-0">
                {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }} — Adoption statistics and trends.
            </p>
        </div>
    </div>

    <!-- Month/Year Filter -->
    <div class="content-card p-3 mb-4">
        <form method="GET" action="{{ route('reports.adoption') }}" class="row g-3 align-items-end">
            <div class="col-auto">
                <label for="month" class="form-label small fw-semibold">Month</label>
                <select id="month" name="month" class="form-select">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" @selected($m == $month)>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-auto">
                <label for="year" class="form-label small fw-semibold">Year</label>
                <select id="year" name="year" class="form-select">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}" @selected($y == $year)>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel me-1"></i> Generate Report
                </button>
            </div>
        </form>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #f0e6ff; color: #6f42c1;">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div class="stat-value">{{ $totalApplications }}</div>
                <div class="stat-label">Applications This Month</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #d1e7dd; color: #0f5132;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-value">{{ $approvedCount }}</div>
                <div class="stat-label">Approved</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #f8d7da; color: #842029;">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stat-value">{{ $rejectedCount }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon mb-2" style="background: #fff3cd; color: #856404;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-value">{{ $pendingCount }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Species Breakdown -->
        <div class="col-lg-4">
            <div class="content-card">
                <div class="p-3 border-bottom">
                    <h2 class="h5 mb-0">Adoptions by Species</h2>
                </div>
                <div class="p-3">
                    @if($speciesBreakdown->isNotEmpty())
                        @foreach($speciesBreakdown as $species => $count)
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-inline-block rounded-circle" style="width: 10px; height: 10px; background: var(--brand-green);"></span>
                                    <span class="fw-semibold">{{ $species }}</span>
                                </div>
                                <span class="badge bg-success rounded-pill">{{ $count }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-secondary text-center mb-0 py-3">No adoptions this month.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Yearly Trend -->
        <div class="col-lg-8">
            <div class="content-card">
                <div class="p-3 border-bottom">
                    <h2 class="h5 mb-0">{{ $year }} Adoptions by Month</h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Adoptions</th>
                                <th>Visual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $maxMonthly = max(1, max($monthlySummary ?: [0])); @endphp
                            @for($m = 1; $m <= 12; $m++)
                                @php $count = $monthlySummary[$m] ?? 0; @endphp
                                <tr class="{{ $m == $month ? 'table-success' : '' }}" style="cursor: pointer;" onclick="window.location='{{ route('reports.adoption', ['month' => $m, 'year' => $year]) }}'">
                                    <td class="fw-semibold">
                                        <a href="{{ route('reports.adoption', ['month' => $m, 'year' => $year]) }}" class="text-decoration-none text-success-emphasis">
                                            {{ DateTime::createFromFormat('!m', $m)->format('M') }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded">
                                            {{ $count }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="height: 12px; width: {{ $count > 0 ? max(8, ($count / $maxMonthly) * 100) : 0 }}%; background: var(--brand-green); border-radius: 4px; transition: width .3s;"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications Detail -->
    @if($adoptions->isNotEmpty())
        <div class="content-card mt-4">
            <div class="p-3 border-bottom">
                <h2 class="h5 mb-0">Adoption Details — {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Pet</th>
                            <th>Species</th>
                            <th>Adopted By</th>
                            <th>Approved On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($adoptions as $adoption)
                            <tr>
                                <td class="fw-semibold">
                                    <a href="{{ route('pets.show', $adoption->pet_id) }}" class="text-decoration-none text-success">
                                        {{ $adoption->pet->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>{{ $adoption->pet->species ?? '-' }}</td>
                                <td>{{ $adoption->user->name }}</td>
                                <td>{{ $adoption->reviewed_at?->format('M d, Y') ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
