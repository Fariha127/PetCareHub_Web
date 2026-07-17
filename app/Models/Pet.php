<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species',
        'breed',
        'age',
        'gender',
        'vaccination_status',
        'adoption_status',
        'image_url',
        'description',
        'habits',
        'food_preference',
        'other_preferences',
    ];

    public function adoptionApplications(): HasMany
    {
        return $this->hasMany(AdoptionApplication::class);
    }

    public function vetCheckups(): HasMany
    {
        return $this->hasMany(VetCheckup::class);
    }

    public function isAvailable(): bool
    {
        return $this->adoption_status === 'Available';
    }

    public function isAdopted(): bool
    {
        return $this->adoption_status === 'Adopted';
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
