<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Submit or toggle an adopter's response to an event (interested/going).
     */
    public function respond(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:interested,going'],
        ]);

        $user = $request->user();

        // Check if the user is an adopter (only adopters should register responses)
        if (!$user->isAdopter()) {
            return back()->with('error', 'Only pet adopters can enroll in events.');
        }

        // Create or update the response
        EventParticipation::updateOrCreate(
            [
                'event_id' => $event->id,
                'user_id' => $user->id,
            ],
            [
                'status' => $validated['status'],
            ]
        );

        $statusText = $validated['status'] === 'going' ? 'are going to' : 'are interested in';

        return back()->with('success', "Thank you! You have marked that you {$statusText} this event.");
    }
}
