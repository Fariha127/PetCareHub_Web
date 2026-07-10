<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\Pet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdoptionApplicationController extends Controller
{
    /**
     * Adopter submits an application to adopt a pet.
     */
    public function store(Request $request, Pet $pet): RedirectResponse
    {
        if (! $pet->isAvailable()) {
            return back()->with('error', 'This pet is no longer available for adoption.');
        }

        // Check for duplicate application
        $existing = AdoptionApplication::where('user_id', $request->user()->id)
            ->where('pet_id', $pet->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already applied to adopt this pet.');
        }

        $request->validate([
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        AdoptionApplication::create([
            'user_id' => $request->user()->id,
            'pet_id' => $pet->id,
            'status' => 'pending',
            'message' => $request->input('message'),
        ]);

        return back()->with('success', 'Your adoption application has been submitted! You will be notified when it is reviewed.');
    }

    /**
     * Shelter staff approves an adoption application.
     * This triggers the observer which auto-updates the pet's adoption_status.
     */
    public function approve(Request $request, AdoptionApplication $application): RedirectResponse
    {
        if (! $application->isPending()) {
            return back()->with('error', 'This application has already been reviewed.');
        }

        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $application->update([
            'status' => 'approved',
            'admin_notes' => $request->input('admin_notes'),
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Application approved! The pet\'s status has been automatically updated to Adopted.');
    }

    /**
     * Shelter staff rejects an adoption application.
     */
    public function reject(Request $request, AdoptionApplication $application): RedirectResponse
    {
        if (! $application->isPending()) {
            return back()->with('error', 'This application has already been reviewed.');
        }

        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $application->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes', 'Application rejected by staff.'),
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Application has been rejected.');
    }
}
