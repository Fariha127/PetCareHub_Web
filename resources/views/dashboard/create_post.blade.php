@extends('layouts.dashboard')

@section('title', 'Seek Help | PetCareHub')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Seek Community Support</h1>
            <p class="text-muted small m-0">Write a request details and post pictures to ask for help.</p>
        </div>
        <a href="{{ route('dashboard.my-posts') }}" class="btn btn-outline-secondary px-3 btn-sm">
            <i class="bi bi-arrow-left"></i> My Posts
        </a>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="content-card p-4 p-md-5 border-0 shadow-sm">
                <!-- Info Alert about Moderation -->
                <div class="alert alert-info border-0 rounded-3 mb-4 d-flex align-items-center gap-3" style="background-color: #f0fdf4; color: #166534;">
                    <span class="fs-3"><i class="bi bi-shield-check"></i></span>
                    <div>
                        <h4 class="h6 fw-bold m-0" style="color: #14532d;">Staff Review Required</h4>
                        <p class="m-0 small">To maintain a safe community space, all posts must be reviewed and approved by our shelter staff before becoming visible to others.</p>
                    </div>
                </div>

                <!-- Global Validation Errors -->
                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 mb-4">
                        <h4 class="h6 fw-bold text-danger mb-2">Please fix the following errors:</h4>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Post Submission Form -->
                <form method="POST" action="{{ route('dashboard.my-posts.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Title of your request <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="e.g., Injured stray cat found near Main Street, need local clinic contacts" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="content" class="form-label fw-semibold">Details / Description <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="6" class="form-control @error('content') is-invalid @enderror" placeholder="Describe the situation in detail. What kind of help are you looking for? Mention location or specific needs..." required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Multiple Image Upload -->
                    <div class="mb-4">
                        <label for="images" class="form-label fw-semibold">Upload Pictures (Maximum 5 pictures) <span class="text-muted small">(Optional)</span></label>
                        <div class="border rounded-3 p-4 bg-light text-center border-dashed">
                            <i class="bi bi-images display-6 mb-3 text-secondary d-block"></i>
                            <input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror" accept="image/*" multiple>
                            <small class="text-muted d-block mt-2">Accepted formats: JPEG, PNG, JPG, GIF, WEBP. Max size: 2MB per file.</small>
                            @error('images')
                                <div class="text-danger small mt-2 d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit and Cancel buttons -->
                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                        <a href="{{ route('dashboard.my-posts') }}" class="btn btn-light px-4 py-2.5">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 py-2.5 fw-semibold">
                            <i class="bi bi-send-fill me-1"></i> Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Tips Panel -->
        <div class="col-xl-4 mt-4 mt-xl-0">
            <div class="content-card p-4 border-0 shadow-sm">
                <h3 class="h6 fw-bold text-uppercase text-secondary mb-3"><i class="bi bi-lightbulb me-1"></i> Posting Best Practices</h3>
                <ol class="list-group list-group-numbered list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-start border-0 py-2.5 px-0">
                        <div class="ms-2 me-auto text-secondary">
                            <div class="fw-bold text-dark">Be Descriptive</div>
                            Describe the exact health condition, age, behavior, and any actions already taken.
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start border-0 py-2.5 px-0">
                        <div class="ms-2 me-auto text-secondary">
                            <div class="fw-bold text-dark">Clear Pictures</div>
                            Upload clear, high-resolution pictures showing the pet, location, or injury. This helps others understand the context.
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start border-0 py-2.5 px-0">
                        <div class="ms-2 me-auto text-secondary">
                            <div class="fw-bold text-dark">Provide Location Details</div>
                            Always specify where you are or where the pet was found, so local volunteers can respond.
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start border-0 py-2.5 px-0">
                        <div class="ms-2 me-auto text-secondary">
                            <div class="fw-bold text-dark">Follow up</div>
                            Once the help is received or situation resolved, reply to the comments to update the community.
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
