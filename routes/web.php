<?php

use App\Http\Controllers\AdoptionApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventManagementController;
use App\Http\Controllers\HelpPostController;
use App\Http\Controllers\HelpPostManagementController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VetCheckupController;
use App\Models\Event;
use App\Models\Pet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $upcomingEvents = collect();
    try {
        DB::connection()->getPdo();

        $availablePetsCount = Pet::where('adoption_status', 'Available')->count();
        $adoptedPetsCount = Pet::where('adoption_status', 'Adopted')->count();

        if ($availablePetsCount === 0 && $adoptedPetsCount === 0) {
            $availablePetsCount = 3;
            $adoptedPetsCount = 1;
        }

        // Fetch upcoming events with creators and response stats
        $upcomingEvents = Event::with('creator')
            ->withCount([
                'participations as going_count' => function ($query) {
                    $query->where('status', 'going');
                },
                'participations as interested_count' => function ($query) {
                    $query->where('status', 'interested');
                }
            ])
            ->upcoming()
            ->get();
    } catch (Throwable) {
        $availablePetsCount = 3;
        $adoptedPetsCount = 1;
    }

    return view('welcome', compact('availablePetsCount', 'adoptedPetsCount', 'upcomingEvents'));
})->name('home');

Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show');

Route::get('/community-supports', [HelpPostController::class, 'index'])->name('community.index');
Route::get('/community-supports/{post}', [HelpPostController::class, 'show'])->name('community.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/profile', [DashboardController::class, 'showProfile'])->name('dashboard.profile');
    Route::get('/dashboard/profile/edit', [DashboardController::class, 'editProfile'])->name('dashboard.profile.edit');
    Route::put('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Community support post routes
    Route::post('/community-supports/{post}/comment', [HelpPostController::class, 'comment'])->name('community.comment');
    // Adoption applications (adopters)
    Route::middleware('role:adopter')->group(function () {
        Route::post('/pets/{pet}/apply', [AdoptionApplicationController::class, 'store'])->name('applications.store');
        Route::get('/dashboard/requests', [DashboardController::class, 'requests'])->name('dashboard.requests');
        Route::get('/dashboard/my-pets', [DashboardController::class, 'myPets'])->name('dashboard.my-pets');
        Route::get('/dashboard/my-events', [DashboardController::class, 'myEvents'])->name('dashboard.my-events');
        Route::post('/events/{event}/respond', [EventController::class, 'respond'])->name('events.respond');
        Route::post('/dashboard/checkups/{checkup}/mark-done', [VetCheckupController::class, 'markDone'])->name('checkups.mark-done');

        // Help posts creation
        Route::get('/dashboard/my-posts', [DashboardController::class, 'myPosts'])->name('dashboard.my-posts');
        Route::get('/dashboard/my-posts/create', [HelpPostController::class, 'create'])->name('dashboard.my-posts.create');
        Route::post('/dashboard/my-posts', [HelpPostController::class, 'store'])->name('dashboard.my-posts.store');
    });

    // Shelter staff routes
    Route::middleware('role:shelter_staff')->group(function () {
        Route::get('/pets-manage/create', [PetController::class, 'create'])->name('pets.create');
        Route::post('/pets-manage', [PetController::class, 'store'])->name('pets.store');
        Route::get('/pets-manage/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
        Route::put('/pets-manage/{pet}', [PetController::class, 'update'])->name('pets.update');
        Route::delete('/pets-manage/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

        Route::post('/applications/{application}/approve', [AdoptionApplicationController::class, 'approve'])->name('applications.approve');
        Route::post('/applications/{application}/reject', [AdoptionApplicationController::class, 'reject'])->name('applications.reject');

        Route::get('/dashboard/users/{user}', [DashboardController::class, 'viewUserProfile'])->name('dashboard.users.show');

        Route::get('/dashboard/events/{event}/participants', [EventManagementController::class, 'participants'])->name('events.participants');
        Route::resource('/dashboard/events', EventManagementController::class)->except(['show']);

        Route::get('/reports/adoption', [ReportController::class, 'monthlyAdoption'])->name('reports.adoption');

        // Help posts moderation
        Route::get('/dashboard/manage-help-posts', [HelpPostManagementController::class, 'index'])->name('dashboard.manage-posts.index');
        Route::post('/dashboard/manage-help-posts/{post}/approve', [HelpPostManagementController::class, 'approve'])->name('dashboard.manage-posts.approve');
        Route::post('/dashboard/manage-help-posts/{post}/reject', [HelpPostManagementController::class, 'reject'])->name('dashboard.manage-posts.reject');
    });

    // Veterinarian routes
    Route::middleware('role:veterinarian')->group(function () {
        Route::post('/checkups', [VetCheckupController::class, 'store'])->name('checkups.store');
    });
});
