<?php

namespace Tests\Feature;

use App\Models\HelpPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CommunitySupportTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_post_creation_routes()
    {
        $response = $this->get(route('dashboard.my-posts.create'));
        $response->assertRedirect(route('login'));

        $response = $this->post(route('dashboard.my-posts.store'), [
            'title' => 'Test Post',
            'content' => 'Test Content',
        ]);
        $response->assertRedirect(route('login'));
    }

    public function test_non_adopters_cannot_access_post_creation_routes()
    {
        $staff = User::factory()->create(['role' => 'shelter_staff']);

        $response = $this->actingAs($staff)->get(route('dashboard.my-posts'));
        $response->assertStatus(403);

        $response = $this->actingAs($staff)->get(route('dashboard.my-posts.create'));
        $response->assertStatus(403);

        $response = $this->actingAs($staff)->post(route('dashboard.my-posts.store'), [
            'title' => 'Test Post',
            'content' => 'Test Content',
        ]);
        $response->assertStatus(403);
    }

    public function test_adopters_can_submit_help_posts_with_multiple_images()
    {
        Storage::fake('public');

        $adopter = User::factory()->create(['role' => 'adopter']);

        $response = $this->actingAs($adopter)->get(route('dashboard.my-posts.create'));
        $response->assertStatus(200);

        $images = [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.jpg'),
        ];

        $response = $this->actingAs($adopter)->post(route('dashboard.my-posts.store'), [
            'title' => 'Injured stray dog in need of shelter',
            'content' => 'Found an injured dog near Springfield park. Seeking local vet contacts.',
            'images' => $images,
        ]);

        $response->assertRedirect(route('dashboard.my-posts'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('help_posts', [
            'title' => 'Injured stray dog in need of shelter',
            'status' => 'pending',
            'user_id' => $adopter->id,
        ]);

        $post = HelpPost::first();
        $this->assertCount(2, $post->images);

        // Check if files are stored in public storage
        foreach ($post->images as $img) {
            Storage::disk('public')->assertExists($img->image_path);
        }
    }

    public function test_unapproved_posts_do_not_appear_on_community_supports_index()
    {
        $adopter = User::factory()->create(['role' => 'adopter']);
        $post = HelpPost::create([
            'user_id' => $adopter->id,
            'title' => 'Pending Help request',
            'content' => 'Some description',
            'status' => 'pending',
        ]);

        $response = $this->get(route('community.index'));
        $response->assertStatus(200);
        $response->assertDontSee('Pending Help request');
    }

    public function test_staff_can_approve_posts_and_make_them_live()
    {
        $adopter = User::factory()->create(['role' => 'adopter']);
        $staff = User::factory()->create(['role' => 'shelter_staff']);

        $post = HelpPost::create([
            'user_id' => $adopter->id,
            'title' => 'Pending Help request',
            'content' => 'Some description',
            'status' => 'pending',
        ]);

        // Non-staff cannot approve
        $response = $this->actingAs($adopter)->post(route('dashboard.manage-posts.approve', $post));
        $response->assertStatus(403);

        // Staff can approve
        $response = $this->actingAs($staff)
            ->from(route('dashboard.manage-posts.index'))
            ->post(route('dashboard.manage-posts.approve', $post));
        $response->assertRedirect(route('dashboard.manage-posts.index'));
        $response->assertSessionHas('success');

        $this->assertEquals('approved', $post->fresh()->status);
        $this->assertEquals($staff->id, $post->fresh()->reviewed_by);

        // Verify it is now visible on community page
        $response = $this->get(route('community.index'));
        $response->assertSee('Pending Help request');
    }

    public function test_authenticated_users_can_comment_on_approved_posts()
    {
        $adopter = User::factory()->create(['role' => 'adopter']);
        $adopter2 = User::factory()->create(['role' => 'adopter']);

        $post = HelpPost::create([
            'user_id' => $adopter->id,
            'title' => 'Approved Help request',
            'content' => 'Some description',
            'status' => 'approved',
        ]);

        // Guest cannot comment
        $response = $this->post(route('community.comment', $post), [
            'content' => 'A guest comment',
        ]);
        $response->assertRedirect(route('login'));

        // Authenticated user can comment
        $response = $this->actingAs($adopter2)->post(route('community.comment', $post), [
            'content' => 'I can bring a pet carrier over.',
        ]);
        $response->assertRedirect();

        $this->assertDatabaseHas('help_post_comments', [
            'help_post_id' => $post->id,
            'user_id' => $adopter2->id,
            'content' => 'I can bring a pet carrier over.',
        ]);
    }

    public function test_users_can_see_their_posts_and_other_comments_in_dashboard()
    {
        $adopter = User::factory()->create(['role' => 'adopter']);
        $commenter = User::factory()->create(['role' => 'adopter']);

        $post = HelpPost::create([
            'user_id' => $adopter->id,
            'title' => 'My first help request',
            'content' => 'Need help',
            'status' => 'approved',
        ]);

        $post->comments()->create([
            'user_id' => $commenter->id,
            'content' => 'Leaving a helpful comment',
        ]);

        $response = $this->actingAs($adopter)->get(route('dashboard.my-posts'));
        $response->assertStatus(200);
        $response->assertSee('My first help request');
        $response->assertSee('Leaving a helpful comment');
    }
}
