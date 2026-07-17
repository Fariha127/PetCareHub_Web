@extends('layouts.app')

@section('title', $post->title . ' | PetCareHub')

@section('content')
<div class="page-section">
    <div class="container">
        <!-- Back navigation link -->
        <div class="mb-4">
            <a href="{{ route('community.index') }}" class="text-secondary text-decoration-none">
                <i class="bi bi-chevron-left"></i> Back to Community Supports
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-5">
            <!-- Left Side: Images and Description -->
            <div class="col-lg-8">
                <div class="content-card p-4 p-md-5 mb-4 shadow-sm border-0">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                        <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-1.5 fw-semibold text-capitalize">
                            <i class="bi bi-person-fill me-1"></i> Posted by: {{ $post->user->name }}
                        </span>
                        <div class="text-muted small">
                            <span class="me-3">
                                <i class="bi bi-calendar3 me-1"></i> {{ $post->created_at->format('M d, Y') }}
                            </span>
                            @if($post->isPending())
                                <span class="badge bg-warning-subtle text-warning-emphasis">Pending Approval</span>
                            @elseif($post->isRejected())
                                <span class="badge bg-danger-subtle text-danger-emphasis">Rejected</span>
                            @endif
                        </div>
                    </div>

                    <h1 class="h2 fw-bold text-dark mb-4">{{ $post->title }}</h1>

                    <!-- Image Carousel for Multiple Pictures -->
                    @if($post->images->isNotEmpty())
                        <div id="helpPostCarousel" class="carousel slide mb-4 rounded-3 overflow-hidden shadow-sm" data-bs-ride="carousel">
                            @if($post->images->count() > 1)
                                <div class="carousel-indicators">
                                    @foreach($post->images as $index => $image)
                                        <button type="button" data-bs-target="#helpPostCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
                                    @endforeach
                                </div>
                            @endif

                            <div class="carousel-inner" style="max-height: 480px; background-color: #000;">
                                @foreach($post->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ $image->url }}" class="d-block w-100 h-100" style="object-fit: contain; aspect-ratio: 16/9; max-height: 480px;" alt="Help Request Picture {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>

                            @if($post->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#helpPostCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#helpPostCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    @endif

                    <!-- Post Body Description -->
                    <div class="post-content mt-4" style="line-height: 1.7; font-size: 1.1rem; color: #374151; white-space: pre-line;">
                        {{ $post->content }}
                    </div>
                </div>
            </div>

            <!-- Right Side: Comments and Actions -->
            <div class="col-lg-4">
                <div class="content-card p-4 shadow-sm border-0">
                    <h3 class="h5 fw-bold mb-4">
                        <i class="bi bi-chat-left-text me-2 text-primary"></i> Comments ({{ $post->comments->count() }})
                    </h3>

                    <!-- Comments List -->
                    <div class="comment-list mb-4 overflow-y-auto" style="max-height: 400px; padding-right: 5px;">
                        @if($post->comments->isEmpty())
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-chat-left display-6 mb-2 d-block opacity-50"></i>
                                <p class="mb-0 small">No comments left yet. Be the first to reply!</p>
                            </div>
                        @else
                            @foreach($post->comments as $comment)
                                <div class="comment-item border-bottom py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold small text-dark">{{ $comment->user->name }}</span>
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill" style="font-size: 0.7rem; padding: 2px 6px;">
                                                {{ ucwords(str_replace('_', ' ', $comment->user->role)) }}
                                            </span>
                                        </div>
                                        <span class="text-muted small" style="font-size: 0.75rem;">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="mb-0 text-secondary small" style="line-height: 1.5; white-space: pre-line;">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Leave Comment Form -->
                    @auth
                        <form method="POST" action="{{ route('community.comment', $post) }}" class="border-top pt-4">
                            @csrf
                            <div class="mb-3">
                                <label for="content" class="form-label fw-semibold small text-secondary">Write a comment</label>
                                <textarea name="content" id="content" rows="4" class="form-control @error('content') is-invalid @enderror" placeholder="Write advice, offers of help, or questions..." required></textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2.5 fw-semibold">
                                <i class="bi bi-send me-1"></i> Post Comment
                            </button>
                        </form>
                    @else
                        <div class="border-top pt-4 text-center">
                            <p class="text-muted small">You must be logged in to reply or write comments.</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-success w-100 py-2 fw-semibold">Log In to Comment</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
