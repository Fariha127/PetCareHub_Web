<?php

namespace App\Observers;

use App\Models\AdoptionApplication;

class AdoptionApplicationObserver
{
    /**
     * When an adoption application is updated:
     * - If approved: mark the pet as "Adopted" and reject all other pending applications for that pet
     * - If rejected: check if any approved application exists; if not and pet was set to Adopted, revert
     */
    public function updated(AdoptionApplication $application): void
    {
        if (! $application->wasChanged('status')) {
            return;
        }

        if ($application->status === 'approved') {
            // Auto-update the pet's adoption status
            $application->pet->update(['adoption_status' => 'Adopted']);

            // Reject all other pending applications for the same pet
            AdoptionApplication::where('pet_id', $application->pet_id)
                ->where('id', '!=', $application->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected',
                    'admin_notes' => 'Auto-rejected: another application was approved.',
                    'reviewed_at' => now(),
                ]);
        }
    }
}
