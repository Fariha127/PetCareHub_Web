@extends('layouts.dashboard')

@section('title', 'Edit Event | PetCareHub')

@section('content')
    <div class="mb-4">
        <a href="{{ route('events.index') }}" class="btn btn-link text-decoration-none p-0 text-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Back to Events
        </a>
        <h1 class="page-title mb-1">Edit Event & Campaign</h1>
        <p class="text-secondary mb-0">Update information for "{{ $event->title }}".</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="content-card p-4">
                <form method="POST" action="{{ route('events.update', $event) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label text-dark fw-semibold">Event Title / Campaign Name</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $event->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="event_date" class="form-label text-dark fw-semibold">Date & Time</label>
                            <input type="datetime-local" class="form-control @error('event_date') is-invalid @enderror" id="event_date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required>
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label text-dark fw-semibold">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $event->location) }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="latitude" class="form-label text-dark fw-semibold">Latitude (Optional)</label>
                            <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $event->latitude) }}" placeholder="e.g. 40.758896">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="longitude" class="form-label text-dark fw-semibold">Longitude (Optional)</label>
                            <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $event->longitude) }}" placeholder="e.g. -73.985130">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>

                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold">Event Location Pin (Click on Map to Update Coordinates)</label>
                        <div id="map" style="height: 350px; border-radius: 8px; border: 1px solid #d6dde3; z-index: 1;"></div>
                    </div>

                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var defaultLat = 23.8103; // Dhaka
                            var defaultLng = 90.4125;
                            
                            var latInput = document.getElementById('latitude');
                            var lngInput = document.getElementById('longitude');
                            var locInput = document.getElementById('location');
                            
                            var activeLat = latInput.value ? parseFloat(latInput.value) : defaultLat;
                            var activeLng = lngInput.value ? parseFloat(lngInput.value) : defaultLng;
                            
                            var map = L.map('map').setView([activeLat, activeLng], 12);
                            
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);

                            var marker;
                            if (latInput.value && lngInput.value) {
                                marker = L.marker([activeLat, activeLng]).addTo(map);
                            }
                            
                            map.on('click', function(e) {
                                var lat = e.latlng.lat.toFixed(6);
                                var lng = e.latlng.lng.toFixed(6);
                                
                                latInput.value = lat;
                                lngInput.value = lng;
                                
                                if (marker) {
                                    marker.setLatLng(e.latlng);
                                } else {
                                    marker = L.marker(e.latlng).addTo(map);
                                }
                                
                                // Fetch address using OpenStreetMap Nominatim API
                                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=en`)
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data && data.display_name) {
                                            // Shorten the address if it is too long
                                            var addr = data.display_name;
                                            var parts = addr.split(',');
                                            if (parts.length > 4) {
                                                addr = parts.slice(0, 4).join(',').trim();
                                            }
                                            locInput.value = addr;
                                        }
                                    })
                                    .catch(err => console.error('Geocoding error:', err));
                            });
                        });
                    </script>

                    <div class="mb-3">
                        <label for="image_url" class="form-label text-dark fw-semibold">Image URL (Optional)</label>
                        <input type="url" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" value="{{ old('image_url', $event->image_url) }}">
                        @error('image_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label text-dark fw-semibold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-3 border-top pt-3">
                        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Update Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
