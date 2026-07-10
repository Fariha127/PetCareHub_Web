<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'phone', 'address', 'occupation'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function adoptionApplications(): HasMany
    {
        return $this->hasMany(AdoptionApplication::class);
    }

    public function vetCheckups(): HasMany
    {
        return $this->hasMany(VetCheckup::class, 'vet_id');
    }

    public function isAdopter(): bool
    {
        return $this->role === 'adopter';
    }

    public function isShelterStaff(): bool
    {
        return $this->role === 'shelter_staff';
    }

    public function isVet(): bool
    {
        return $this->role === 'veterinarian';
    }

    public function getRoleDisplayAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->role));
    }
}
