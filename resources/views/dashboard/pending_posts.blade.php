@extends('layouts.dashboard')

@section('title', 'Moderate Help Requests | PetCareHub')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Pending Help Requests</h1>
        <p class="text-muted small m-0">Vet and moderate community help requests before they appear on the public Community Supports board.</p>
    </div>

    @if($posts->isEmpty())
        <div class="content-card p-5 text-center shadow-sm border-0">
            <div class="display-1 text-success mb-3"><i class="bi bi-shield-check"></i></div>
            <h3 class="fw-bold text-success">All Caught Up!</h3>
            <p class="text-muted mx-auto m-0" style="max-width: 500px;">There are no pending community support requests awaiting your review.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-12">
                    <div class="content-card p-4 shadow-sm border-0">
                        <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-3 mb-3 gap-2">
                            <div>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-1.5 fw-semibold text-capitalize small">
                                    <i class="bi bi-person-circle"></i> Submitted by: {{ $post->user->name }} ({{ ucwords(str_replace('_', ' ', $post->user->role)) }})
                                </span>
                            </div>
                            <span class="text-muted small">
                                <i class="bi bi-clock me-1"></i> {{ $post->created_at->format('M d, Y, h:i A') }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <h3 class="h5 fw-bold text-dark mb-2">{{ $post->title }}</h3>
                            <p class="text-secondary small mb-3" style="line-height: 1.6; white-space: pre-line;">{{ $post->content }}</p>

                            @if($post->images->isNotEmpty())
                                <h4 class="h6 fw-bold mb-2 text-muted"><i class="bi bi-images me-1"></i> Attached Pictures ({{ $post->images->count() }})</h4>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach($post->images as $img)
                                        <a href="{{ $img->url }}" target="_blank" class="d-block border rounded overflow-hidden" style="width: 120px; height: 120px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                            <img src="{{ $img->url }}" class="w-100 h-100" style="object-fit: cover;" alt="Attached Image">
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Moderation Action Forms -->
                        <div class="d-flex justify-content-end gap-3 border-top pt-3">
                            <form method="POST" action="{{ route('dashboard.manage-posts.reject', $post) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger px-4 py-2 small fw-semibold" onclick="return confirm('Are you sure you want to reject this request?')">
                                    <i class="bi bi-x-circle me-1"></i> Reject Post
                                </button>
                            </form>
                            <form method="POST" action="{{ route('dashboard.manage-posts.approve', $post) }}">
                                @csrf
                                <button type="submit" class="btn btn-success px-4 py-2 small fw-semibold">
                                    <i class="bi bi-check-circle me-1"></i> Approve & Publish
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
