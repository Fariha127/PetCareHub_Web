<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PetController extends Controller
{
    public function index(Request $request): View
    {
        $pets = $this->pets($request);

        return view('pets.index', [
            'pets' => $pets,
            'speciesOptions' => $pets->pluck('species')->unique()->sort()->values(),
            'filters' => $request->only(['search', 'species', 'availability']),
        ]);
    }

    public function show(string $pet): View
    {
        $pet = $this->findPet($pet);

        abort_if($pet === null, 404);

        return view('pets.show', ['pet' => $pet]);
    }

    private function pets(Request $request): Collection
    {
        try {
            DB::connection()->getPdo();

            $query = Pet::query()->latest();

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
                $query->where('species', $request->string('species'));
            }

            if ($request->filled('availability')) {
                $query->where('adoption_status', $request->string('availability'));
            }

            $pets = $query->get();

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
            $pets = $pets->where('species', $request->string('species')->toString());
        }

        if ($request->filled('availability')) {
            $pets = $pets->where('adoption_status', $request->string('availability')->toString());
        }

        return new Collection($pets->values()->all());
    }
}
