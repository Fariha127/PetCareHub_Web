<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\HelpPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HelpPostManagementController extends Controller
{
    /**
     * List all pending help posts for shelter staff moderation.
     */
    public function index(): View
    {
        $posts = HelpPost::with(['user', 'images'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('dashboard.pending_posts', compact('posts'));
    }

    /**
     * Approve a help post.
     */
    public function approve(Request $request, HelpPost $post): RedirectResponse
    {
        if (!$post->isPending()) {
            return redirect()->route('dashboard.manage-posts.index')->with('error', 'This post has already been reviewed.');
        }

        $post->update([
            'status' => 'approved',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('dashboard.manage-posts.index')->with('success', 'Help post has been approved and is now live on Community Supports.');
    }

    /**
     * Reject a help post.
     */
    public function reject(Request $request, HelpPost $post): RedirectResponse
    {
        if (!$post->isPending()) {
            return redirect()->route('dashboard.manage-posts.index')->with('error', 'This post has already been reviewed.');
        }

        $post->update([
            'status' => 'rejected',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('dashboard.manage-posts.index')->with('success', 'Help post has been rejected.');
    }
}
