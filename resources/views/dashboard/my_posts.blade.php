@extends('layouts.dashboard')

@section('title', 'My Help Posts | PetCareHub')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">My Help Posts</h1>
            <p class="text-muted small m-0">View all your community support requests, status updates, and comments received.</p>
        </div>
        <a href="{{ route('dashboard.my-posts.create') }}" class="btn btn-success px-4 fw-semibold d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> New Help Request
        </a>
    </div>

    @if($posts->isEmpty())
        <div class="content-card p-5 text-center shadow-sm border-0">
            <div class="display-1 text-secondary mb-3"><i class="bi bi-balloon-heart"></i></div>
            <h3 class="fw-bold">No Help Requests Yet</h3>
            <p class="text-muted mx-auto" style="max-width: 500px;">If you encounter stray animals, need rescue resources, or medical help, you can seek assistance from our community.</p>
            <a href="{{ route('dashboard.my-posts.create') }}" class="btn btn-primary mt-3 px-4">Create Your First Post</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-12">
                    <div class="content-card p-4 shadow-sm border-0 d-flex flex-column gap-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 border-bottom pb-3">
                            <div>
                                <h3 class="h5 fw-bold text-dark mb-1">
                                    {{ $post->title }}
                                </h3>
                                <span class="text-muted small">
                                    <i class="bi bi-clock me-1"></i> Submitted {{ $post->created_at->format('M d, Y, h:i A') }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if($post->isPending())
                                    <span class="badge badge-pending px-3 py-1.5 rounded-pill text-capitalize font-semibold">
                                        <i class="bi bi-hourglass-split me-1"></i> Pending Approval
                                    </span>
                                @elseif($post->isApproved())
                                    <span class="badge badge-approved px-3 py-1.5 rounded-pill text-capitalize font-semibold">
                                        <i class="bi bi-check-circle-fill me-1"></i> Approved & Live
                                    </span>
                                    <a href="{{ route('community.show', $post) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill" target="_blank">
                                        View Post <i class="bi bi-box-arrow-up-right ms-1"></i>
                                    </a>
                                @elseif($post->isRejected())
                                    <span class="badge badge-rejected px-3 py-1.5 rounded-pill text-capitalize font-semibold">
                                        <i class="bi bi-x-circle-fill me-1"></i> Rejected
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Left: Description and Photos -->
                            <div class="col-lg-7">
                                <p class="text-secondary small mb-3" style="line-height: 1.6; white-space: pre-line;">{{ $post->content }}</p>

                                @if($post->images->isNotEmpty())
                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                        @foreach($post->images as $img)
                                            <a href="{{ $img->url }}" target="_blank" class="d-block border rounded overflow-hidden" style="width: 80px; height: 80px;">
                                                <img src="{{ $img->url }}" class="w-100 h-100" style="object-fit: cover;" alt="Thumbnail">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Right: Comments Section -->
                            <div class="col-lg-5 border-start-lg">
                                <div class="bg-light p-3 rounded-3 h-100">
                                    <h4 class="h6 fw-bold mb-3 text-secondary d-flex align-items-center justify-content-between">
                                        <span><i class="bi bi-chat-left-text me-1"></i> Comments ({{ $post->comments->count() }})</span>
                                    </h4>

                                    <div class="comment-scroller" style="max-height: 250px; overflow-y: auto; padding-right: 5px;">
                                        @if($post->comments->isEmpty())
                                            <div class="text-center py-4 text-muted small">
                                                <i class="bi bi-chat-dots d-block fs-3 opacity-50 mb-1"></i>
                                                No comments left on this post yet.
                                            </div>
                                        @else
                                            @foreach($post->comments as $comment)
                                                <div class="bg-white p-2.5 rounded-2 border shadow-2xs mb-2 small">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <div class="d-flex align-items-center gap-1.5">
                                                            <span class="fw-bold text-dark" style="font-size: 0.8rem;">{{ $comment->user->name }}</span>
                                                            <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill" style="font-size: 0.65rem; padding: 1px 5px;">
                                                                {{ ucwords(str_replace('_', ' ', $comment->user->role)) }}
                                                            </span>
                                                        </div>
                                                        <span class="text-muted" style="font-size: 0.7rem;">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="m-0 text-secondary" style="line-height: 1.4; white-space: pre-line; font-size: 0.8rem;">{{ $comment->content }}</p>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
