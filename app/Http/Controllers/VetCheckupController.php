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
}
