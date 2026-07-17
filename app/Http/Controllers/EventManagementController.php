<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipation;
use GuzzleHttp\Client;
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
            'latitude' => ['nullable', 'numeric', 'min:-90', 'max:90'],
            'longitude' => ['nullable', 'numeric', 'min:-180', 'max:180'],
        ]);

        $validated['created_by'] = $request->user()->id;

        $validated = $this->geocodeLocation($validated);

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
            'latitude' => ['nullable', 'numeric', 'min:-90', 'max:90'],
            'longitude' => ['nullable', 'numeric', 'min:-180', 'max:180'],
        ]);

        $validated = $this->geocodeLocation($validated);

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

    /**
     * Helper method to geocode address names using Guzzle and Nominatim API.
     */
    private function geocodeLocation(array $validated): array
    {
        if (empty($validated['latitude']) || empty($validated['longitude'])) {
            try {
                $client = new Client();
                $response = $client->request('GET', 'https://nominatim.openstreetmap.org/search', [
                    'headers' => [
                        'User-Agent' => 'PetCareHub-App/1.0 (contact@petcarehub.demo)'
                    ],
                    'query' => [
                        'q' => $validated['location'],
                        'format' => 'json',
                        'limit' => 1
                    ]
                ]);

                $data = json_decode($response->getBody()->getContents(), true);

                if (!empty($data) && isset($data[0])) {
                    $validated['latitude'] = $data[0]['lat'];
                    $validated['longitude'] = $data[0]['lon'];
                }
            } catch (\Exception $e) {
                // Ignore and fallback
            }
        }

        return $validated;
    }
}
