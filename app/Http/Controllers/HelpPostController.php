<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\HelpPost;
use App\Models\HelpPostComment;
use App\Models\HelpPostImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HelpPostController extends Controller
{
    /**
     * Display a listing of approved help posts (Community Supports).
     */
    public function index(Request $request): View
    {
        $posts = HelpPost::with(['user', 'images'])
            ->withCount('comments')
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('community_supports.index', compact('posts'));
    }

    /**
     * Display a specific help post with its comments.
     */
    public function show(HelpPost $post): View
    {
        abort_unless($post->isApproved() || (auth()->check() && (auth()->id() === $post->user_id || auth()->user()->isShelterStaff())), 403);

        $post->load(['user', 'images', 'comments.user']);

        return view('community_supports.show', compact('post'));
    }

    /**
     * Show the form for creating a new help post.
     */
    public function create(): View
    {
        return view('dashboard.create_post');
    }

    /**
     * Store a newly created help post.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ], [
            'images.max' => 'You cannot upload more than 5 pictures.',
            'images.*.image' => 'Each uploaded file must be an image.',
            'images.*.max' => 'Each image size must not exceed 2MB.',
        ]);

        $post = HelpPost::create([
            'user_id' => $request->user()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'status' => 'pending', // Starts as pending, needs approval
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('help_posts', 'public');
                $post->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('dashboard.my-posts')->with('success', 'Your help post has been submitted! It will appear in Community Supports once approved by shelter staff.');
    }

    /**
     * Submit a comment on a help post.
     */
    public function comment(Request $request, HelpPost $post): RedirectResponse
    {
        $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $post->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Your comment has been posted successfully.');
    }
}
