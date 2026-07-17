@extends('layouts.app')

@section('title', 'Community Supports | PetCareHub')

@section('content')
<div class="page-section">
    <div class="container">
        <!-- Header Section with Brand Colors -->
        <div class="text-center mb-5">
            <span class="eyebrow">Mutual Aid & Help</span>
            <h1 class="hero-title mb-3">Community Supports</h1>
            <p class="muted-copy mx-auto" style="max-width: 600px;">
                Read stories, view requests, and support our community. Register or log in to create your own request or leave comments.
            </p>
            @auth
                <a href="{{ route('dashboard.my-posts.create') }}" class="btn btn-primary btn-lg mt-3 px-4 py-2">
                    <i class="bi bi-plus-circle me-2"></i> Seek Help
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-success btn-lg mt-3 px-4 py-2">
                    Log in to Seek Help
                </a>
            @endauth
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($posts->isEmpty())
            <div class="content-card p-5 text-center my-4">
                <div class="display-1 text-secondary mb-3"><i class="bi bi-journal-x"></i></div>
                <h3 class="fw-bold">No Support Posts Yet</h3>
                <p class="text-muted">There are no approved support requests at the moment. Check back later!</p>
            </div>
        @else
            <!-- Grid of Cards -->
            <div class="row g-4">
                @foreach($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 pet-card border-0 shadow-sm overflow-hidden d-flex flex-column">
                            <!-- Image Section -->
                            @if($post->images->isNotEmpty())
                                <div class="position-relative" style="height: 240px;">
                                    <img src="{{ $post->images->first()->url }}" class="w-100 h-100" style="object-fit: cover;" alt="Help Request Image">
                                    @if($post->images->count() > 1)
                                        <span class="position-absolute bottom-0 end-0 bg-dark bg-opacity-75 text-white px-2 py-1 m-2 rounded small fw-bold">
                                            <i class="bi bi-images me-1"></i> +{{ $post->images->count() - 1 }} photos
                                        </span>
                                    @endif
                                </div>
                            @else
                                <!-- Nice fallback gradient when no image is uploaded -->
                                <div class="w-100 d-flex align-items-center justify-content-center text-white" style="height: 240px; background: var(--brand-gradient);">
                                    <div class="text-center">
                                        <i class="bi bi-heart-pulse-fill display-3"></i>
                                        <p class="m-0 mt-2 fw-semibold">Care & Support</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Body Section -->
                            <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-1.5 fw-semibold text-capitalize">
                                        <i class="bi bi-person-fill me-1"></i> {{ $post->user->name }}
                                    </span>
                                    <span class="text-muted small">
                                        <i class="bi bi-calendar3 me-1"></i> {{ $post->created_at->format('M d, Y') }}
                                    </span>
                                </div>

                                <h3 class="h4 card-title fw-bold text-dark mb-2 text-truncate" title="{{ $post->title }}">
                                    {{ $post->title }}
                                </h3>

                                <p class="card-text text-muted mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    {{ $post->content }}
                                </p>

                                <div class="mt-auto d-flex justify-content-between align-items-center border-top pt-3">
                                    <span class="text-muted fw-semibold small">
                                        <i class="bi bi-chat-left-text me-1 text-primary"></i> {{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}
                                    </span>
                                    <a href="{{ route('community.show', $post) }}" class="btn btn-outline-success px-3 btn-sm">
                                        View Details <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
