<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VetCheckup extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'vet_id',
        'checkup_date',
        'weight',
        'temperature',
        'diagnosis',
        'treatment',
        'next_checkup_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'checkup_date' => 'date',
            'next_checkup_date' => 'date',
            'weight' => 'decimal:2',
            'temperature' => 'decimal:2',
        ];
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function vet(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vet_id');
    }
}
