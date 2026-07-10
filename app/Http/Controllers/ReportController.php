<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Monthly adoption report with statistics.
     */
    public function monthlyAdoption(Request $request): View
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        // Applications for the selected month
        $applications = AdoptionApplication::with(['user', 'pet'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        // Approved applications (adoptions) for the selected month
        $adoptions = AdoptionApplication::with(['user', 'pet'])
            ->where('status', 'approved')
            ->whereYear('reviewed_at', $year)
            ->whereMonth('reviewed_at', $month)
            ->get();

        // Species breakdown of adopted pets this month
        $speciesBreakdown = $adoptions->groupBy(fn ($app) => $app->pet->species ?? 'Unknown')
            ->map->count()
            ->sortByDesc(fn ($count) => $count);

        // Monthly summary for the year (for chart/table)
        $monthlySummary = AdoptionApplication::where('status', 'approved')
            ->whereNotNull('reviewed_at')
            ->whereYear('reviewed_at', $year)
            ->selectRaw('MONTH(reviewed_at) as month, COUNT(*) as total')
            ->groupByRaw('MONTH(reviewed_at)')
            ->orderByRaw('MONTH(reviewed_at)')
            ->pluck('total', 'month')
            ->toArray();

        return view('dashboard.reports', [
            'year' => $year,
            'month' => $month,
            'applications' => $applications,
            'adoptions' => $adoptions,
            'totalApplications' => $applications->count(),
            'approvedCount' => $applications->where('status', 'approved')->count(),
            'rejectedCount' => $applications->where('status', 'rejected')->count(),
            'pendingCount' => $applications->where('status', 'pending')->count(),
            'speciesBreakdown' => $speciesBreakdown,
            'monthlySummary' => $monthlySummary,
        ]);
    }
}
