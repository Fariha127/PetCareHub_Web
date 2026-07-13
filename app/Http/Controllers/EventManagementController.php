<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventManagementController extends Controller
{
    public function index(): View
    {
        // Get events created by this staff or all events
        $events = Event::with('creator')
            ->withCount([
                'participations as going_count' => function ($query) {
                    $query->where('status', 'going');
                },
                'participations as interested_count' => function ($query) {
                    $query->where('status', 'interested');
                }
            ])
            ->latest()
            ->get();

        return view('events.index', compact('events'));
    }

    public function create(): View
    {
        return view('events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'location' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'image_url' => ['nullable', 'url', 'max:500'],
        ]);

        $validated['created_by'] = $request->user()->id;

        $event = Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event): View
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'location' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'image_url' => ['nullable', 'url', 'max:500'],
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    public function participants(Event $event): View
    {
        // Load event participants grouped by status
        $going = EventParticipation::with('user')
            ->where('event_id', $event->id)
            ->where('status', 'going')
            ->get();

        $interested = EventParticipation::with('user')
            ->where('event_id', $event->id)
            ->where('status', 'interested')
            ->get();

        return view('events.participants', compact('event', 'going', 'interested'));
    }
}
