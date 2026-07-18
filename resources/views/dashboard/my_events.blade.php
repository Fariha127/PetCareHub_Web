@extends('layouts.dashboard')

@section('title', 'My Events | PetCareHub')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="page-title mb-1">My Events</h1>
            <p class="text-secondary mb-0">Browse and manage the shelter events you have signed up for.</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="bi bi-calendar-event me-1"></i> Find More Events
        </a>
    </div>


    @if($participations->isNotEmpty())
        <div class="row g-4">
            @foreach($participations as $participation)
                @php $event = $participation->event; @endphp
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="content-card h-100 overflow-hidden shadow-sm d-flex flex-column border-light-subtle">
                        <div class="position-relative" style="height: 160px;">
                            @if(!empty($event->image_url))
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center border-bottom">
                                    <i class="bi bi-calendar-event text-secondary fs-1"></i>
                                </div>
                            @endif
                            <div class="position-absolute top-0 right-0 p-2">
                                @if($participation->status === 'going')
                                    <span class="badge bg-success rounded-pill shadow-sm">Going</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill shadow-sm">Interested</span>
                                @endif
                            </div>
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <span class="text-success small fw-semibold mb-1 d-block">
                                <i class="bi bi-calendar-date"></i> {{ $event->event_date->format('M d, Y @ h:i A') }}
                            </span>
                            <h3 class="h6 fw-bold mb-2 text-dark">{{ $event->title }}</h3>
                            <p class="small text-secondary mb-3 flex-grow-1">{{ Str::limit($event->description, 100) }}</p>
                            
                            <div class="border-top pt-2 mt-auto">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-3 text-secondary small">
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="bi bi-geo-alt-fill text-danger"></i> <span>{{ $event->location }}</span>
                                    </div>
                                    @if($event->latitude && $event->longitude)
                                        <button type="button" class="btn btn-link p-0 text-decoration-none btn-sm fw-semibold view-map-btn" 
                                                data-lat="{{ $event->latitude }}" 
                                                data-lng="{{ $event->longitude }}"
                                                data-title="{{ $event->title }}"
                                                data-loc="{{ $event->location }}"
                                                style="color: var(--brand-pink); font-size: 0.85rem;">
                                            <i class="bi bi-map-fill"></i> View on Map
                                        </button>
                                    @endif
                                </div>
                                
                                <form method="POST" action="{{ route('events.respond', $event) }}" class="d-flex gap-2">
                                    @csrf
                                    @if($participation->status === 'going')
                                        <button type="submit" name="status" value="interested" class="btn btn-sm btn-outline-warning text-dark w-100 rounded-pill">
                                            Change to Interested
                                        </button>
                                    @else
                                        <button type="submit" name="status" value="going" class="btn btn-sm btn-outline-success w-100 rounded-pill">
                                            Change to Going
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="content-card text-center p-5">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-calendar-x text-secondary fs-2"></i>
            </div>
            <h2 class="h5 fw-bold text-dark mb-2">No Enrolled Events</h2>
            <p class="text-secondary mx-auto mb-4" style="max-width: 400px;">
                You haven't responded to any upcoming shelter events yet. Check out the homepage to join campaigns, street feeding events, and support pet adoptions!
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary px-4">
                <i class="bi bi-calendar-event me-1"></i> View Shelter Events
            </a>
        </div>
    @endif

    <!-- Map Modal -->
    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: 1px solid var(--line); overflow: hidden;">
                <div class="modal-header border-0 pb-0" style="background: var(--wash);">
                    <h5 class="modal-title fw-bold" id="mapModalLabel" style="color: var(--brand-pink-dark); font-size: 1.25rem;">Event Location Map</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background: var(--wash);">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-geo-alt-fill text-danger" style="font-size: 1.15rem;"></i>
                        <span class="text-secondary fw-semibold" id="mapLocationText" style="font-size: 0.95rem;"></span>
                    </div>
                    <div id="leafletMap" style="height: 400px; width: 100%; border-radius: 8px; border: 1px solid var(--line); box-shadow: 0 4px 15px rgba(225, 27, 104, 0.05); z-index: 1;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JS & CSS for OpenStreetMap integration -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let mapInstance = null;
            let markerInstance = null;
            const mapModalElement = document.getElementById('mapModal');
            const mapModal = new bootstrap.Modal(mapModalElement);

            // Click listener for view map button
            document.querySelectorAll('.view-map-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const lat = parseFloat(this.getAttribute('data-lat'));
                    const lng = parseFloat(this.getAttribute('data-lng'));
                    const title = this.getAttribute('data-title');
                    const loc = this.getAttribute('data-loc');

                    document.getElementById('mapModalLabel').textContent = title + ' - Map';
                    document.getElementById('mapLocationText').textContent = loc;

                    mapModal.show();

                    // Leaflet requires container visibility to render correctly,
                    // so we initialize/re-center the map inside the modal's shown event.
                    mapModalElement.addEventListener('shown.bs.modal', function onShown() {
                        // Remove listener to prevent multiple triggers
                        mapModalElement.removeEventListener('shown.bs.modal', onShown);

                        if (mapInstance === null) {
                            mapInstance = L.map('leafletMap').setView([lat, lng], 15);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(mapInstance);
                        } else {
                            mapInstance.setView([lat, lng], 15);
                            mapInstance.invalidateSize();
                        }

                        // Remove existing marker if any
                        if (markerInstance !== null) {
                            mapInstance.removeLayer(markerInstance);
                        }

                        // Add marker with popup
                        markerInstance = L.marker([lat, lng]).addTo(mapInstance)
                            .bindPopup(`<strong>${title}</strong><br>${loc}`)
                            .openPopup();
                    });
                });
            });
        });
    </script>
@endsection
