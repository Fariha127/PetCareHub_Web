<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdoptionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pet_id',
        'status',
        'message',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::updated(function (AdoptionApplication $application) {
            if ($application->wasChanged('status') && $application->status === 'approved') {
                // Auto-update the pet's adoption status
                $application->pet->update(['adoption_status' => 'Adopted']);

                // Reject all other pending applications for the same pet
                static::where('pet_id', $application->pet_id)
                    ->where('id', '!=', $application->id)
                    ->where('status', 'pending')
                    ->update([
                        'status' => 'rejected',
                        'admin_notes' => 'Auto-rejected: another application was approved.',
                        'reviewed_at' => now(),
                    ]);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
