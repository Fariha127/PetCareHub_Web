<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PetController extends Controller
{
    public function index(Request $request): View
    {
        $pets = $this->pets($request);
        $options = $this->filterOptions();

        return view('pets.index', [
            'pets' => $pets,
            'speciesOptions' => $options['species'],
            'breedOptions' => $options['breeds'],
            'filters' => $request->only(['search', 'species', 'breed', 'age', 'vaccination', 'adoption_status', 'sort']),
        ]);
    }

    public function show(string $pet): View
    {
        $pet = $this->findPet($pet);

        abort_if($pet === null, 404);

        // Load vet checkups if the pet is a model instance
        $checkups = collect();
        if ($pet instanceof Pet) {
            $checkups = $pet->vetCheckups()->with('vet')->latest('checkup_date')->get();
        }

        // Check if current user has an existing application
        $existingApplication = null;
        if (auth()->check() && auth()->user()->isAdopter()) {
            if ($pet instanceof Pet) {
                $existingApplication = $pet->adoptionApplications()
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->first();
            }
        }

        return view('pets.show', [
            'pet' => $pet,
            'checkups' => $checkups,
            'existingApplication' => $existingApplication,
        ]);
    }

    /**
     * Show form to create a new pet (shelter staff).
     */
    public function create(): View
    {
        return view('pets.create');
    }

    /**
     * Store a new pet (shelter staff).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'species' => ['required', 'string', 'max:255'],
            'breed' => ['nullable', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:0', 'max:100'],
            'gender' => ['required', 'in:Male,Female'],
            'vaccination_status' => ['required', 'in:Vaccinated,Not Vaccinated'],
            'adoption_status' => ['required', 'in:Available,Adopted'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $pet = Pet::create($validated);

        return redirect()->route('pets.show', $pet)->with('success', 'Pet has been added successfully.');
    }

    /**
     * Show form to edit a pet (shelter staff).
     */
    public function edit(Pet $pet): View
    {
        return view('pets.edit', ['pet' => $pet]);
    }

    /**
     * Update a pet (shelter staff).
     */
    public function update(Request $request, Pet $pet): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'species' => ['required', 'string', 'max:255'],
            'breed' => ['nullable', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:0', 'max:100'],
            'gender' => ['required', 'in:Male,Female'],
            'vaccination_status' => ['required', 'in:Vaccinated,Not Vaccinated'],
            'adoption_status' => ['required', 'in:Available,Adopted'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $pet->update($validated);

        return redirect()->route('pets.show', $pet)->with('success', 'Pet has been updated successfully.');
    }

    /**
     * Delete a pet (shelter staff).
     */
    public function destroy(Pet $pet): RedirectResponse
    {
        $pet->delete();

        return redirect()->route('pets.index')->with('success', 'Pet has been removed.');
    }

    private function pets(Request $request): Collection
    {
        try {
            DB::connection()->getPdo();

            $query = Pet::query();

            if ($request->filled('search')) {
                $search = $request->string('search');
                $query->where(function ($builder) use ($search) {
                    $builder
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('species', 'like', "%{$search}%")
                        ->orWhere('breed', 'like', "%{$search}%");
                });
            }

            if ($request->filled('species')) {
                $query->where('species', 'like', '%' . $request->string('species') . '%');
            }

            if ($request->filled('breed')) {
                $query->where('breed', 'like', '%' . $request->string('breed') . '%');
            }

            if ($request->filled('age')) {
                $query->where('age', $request->integer('age'));
            }

            if ($request->filled('vaccination')) {
                $query->where('vaccination_status', $request->string('vaccination'));
            }

            if ($request->filled('adoption_status')) {
                $query->where('adoption_status', $request->string('adoption_status'));
            }

            match ($request->string('sort')->toString()) {
                'age_asc' => $query->orderBy('age'),
                'age_desc' => $query->orderByDesc('age'),
                default => $query->latest(),
            };

            $pets = $query->get();

            if ($request->filled('species') && $pets->isEmpty()) {
                $pets = $this->samplePets($request);
            }

            return $pets->isNotEmpty() ? $pets : $this->samplePets($request);
        } catch (\Throwable) {
            return $this->samplePets($request);
        }
    }

    private function findPet(string $id): ?object
    {
        try {
            DB::connection()->getPdo();

            $pet = Pet::find($id);

            if ($pet !== null) {
                return $pet;
            }
        } catch (\Throwable) {
            //
        }

        return $this->samplePets()->firstWhere('id', (int) $id);
    }

    private function filterOptions(): array
    {
        try {
            DB::connection()->getPdo();

            $species = Pet::query()
                ->whereNotNull('species')
                ->distinct()
                ->orderBy('species')
                ->pluck('species');

            $breeds = Pet::query()
                ->whereNotNull('breed')
                ->distinct()
                ->orderBy('breed')
                ->pluck('breed');

            if ($species->isNotEmpty() || $breeds->isNotEmpty()) {
                return [
                    'species' => $species,
                    'breeds' => $breeds,
                ];
            }
        } catch (\Throwable) {
            //
        }

        $samplePets = $this->samplePets();

        return [
            'species' => $samplePets->pluck('species')->unique()->sort()->values(),
            'breeds' => $samplePets->pluck('breed')->filter()->unique()->sort()->values(),
        ];
    }

    private function samplePets(?Request $request = null): Collection
    {
        $pets = collect([
            (object) [
                'id' => 1,
                'name' => 'Milo',
                'species' => 'Cat',
                'breed' => 'Domestic Shorthair',
                'age' => 2,
                'gender' => 'Male',
                'vaccination_status' => 'Vaccinated',
                'adoption_status' => 'Available',
                'image_url' => 'https://images.unsplash.com/photo-1574158622682-e40e69881006?auto=format&fit=crop&w=900&q=80',
                'description' => 'A calm indoor cat who enjoys sunny windows and gentle attention.',
            ],
            (object) [
                'id' => 2,
                'name' => 'Bella',
                'species' => 'Dog',
                'breed' => 'Labrador Mix',
                'age' => 4,
                'gender' => 'Female',
                'vaccination_status' => 'Vaccinated',
                'adoption_status' => 'Available',
                'image_url' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=900&q=80',
                'description' => 'Friendly, active, and ready for a family that enjoys daily walks.',
            ],
            (object) [
                'id' => 3,
                'name' => 'Rio',
                'species' => 'Bird',
                'breed' => 'Parakeet',
                'age' => 1,
                'gender' => 'Male',
                'vaccination_status' => 'Not Vaccinated',
                'adoption_status' => 'Available',
                'image_url' => 'https://images.unsplash.com/photo-1522926193341-e9ffd686c60f?auto=format&fit=crop&w=900&q=80',
                'description' => 'A bright, social parakeet suited for a quiet and attentive home.',
            ],
            (object) [
                'id' => 4,
                'name' => 'Luna',
                'species' => 'Cat',
                'breed' => 'Persian',
                'age' => 3,
                'gender' => 'Female',
                'vaccination_status' => 'Vaccinated',
                'adoption_status' => 'Adopted',
                'image_url' => 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?auto=format&fit=crop&w=900&q=80',
                'description' => 'Gentle and affectionate, currently shown as part of adoption history.',
            ],
        ]);

        if ($request === null) {
        return new Collection($pets->all());
        }

        if ($request->filled('search')) {
            $search = strtolower($request->string('search'));
            $pets = $pets->filter(fn ($pet) => str_contains(strtolower("{$pet->name} {$pet->species} {$pet->breed}"), $search));
        }

        if ($request->filled('species')) {
            $species = strtolower($request->string('species'));
            $pets = $pets->filter(fn ($pet) => str_contains(strtolower($pet->species), $species));
        }

        if ($request->filled('breed')) {
            $breed = strtolower($request->string('breed'));
            $pets = $pets->filter(fn ($pet) => str_contains(strtolower($pet->breed), $breed));
        }

        if ($request->filled('age')) {
            $pets = $pets->where('age', $request->integer('age'));
        }

        if ($request->filled('vaccination')) {
            $pets = $pets->where('vaccination_status', $request->string('vaccination')->toString());
        }

        if ($request->filled('adoption_status')) {
            $pets = $pets->where('adoption_status', $request->string('adoption_status')->toString());
        }

        $pets = match ($request->string('sort')->toString()) {
            'age_asc' => $pets->sortBy('age'),
            'age_desc' => $pets->sortByDesc('age'),
            default => $pets->sortByDesc('id'),
        };

        return new Collection($pets->values()->all());
    }
}
