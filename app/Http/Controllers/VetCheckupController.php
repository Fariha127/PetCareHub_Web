<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\VetCheckup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VetCheckupController extends Controller
{
    /**
     * Veterinarian creates a new checkup record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pet_id' => ['required', 'exists:pets,id'],
            'checkup_date' => ['required', 'date'],
            'weight' => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'temperature' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'diagnosis' => ['nullable', 'string', 'max:255'],
            'treatment' => ['nullable', 'string', 'max:2000'],
            'next_checkup_date' => ['nullable', 'date', 'after:checkup_date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['vet_id'] = $request->user()->id;

        VetCheckup::create($validated);

        return back()->with('success', 'Checkup record has been saved successfully.');
    }

    /**
     * Mark a scheduled next checkup as done.
     */
    public function markDone(Request $request, VetCheckup $checkup): RedirectResponse
    {
        $user = $request->user();

        $isOwner = $user->adoptionApplications()
            ->where('pet_id', $checkup->pet_id)
            ->where('status', 'approved')
            ->exists();

        if (!$isOwner) {
            abort(403, 'Unauthorized action.');
        }

        $checkup->update([
            'next_checkup_done' => true,
        ]);

        return back()->with('success', 'Medical checkup reminder has been marked as completed.');
    }
}
