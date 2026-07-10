<?php

use App\Http\Controllers\AdoptionApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VetCheckupController;
use App\Models\Pet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    try {
        DB::connection()->getPdo();

        $availablePetsCount = Pet::where('adoption_status', 'Available')->count();
        $adoptedPetsCount = Pet::where('adoption_status', 'Adopted')->count();

        if ($availablePetsCount === 0 && $adoptedPetsCount === 0) {
            $availablePetsCount = 3;
            $adoptedPetsCount = 1;
        }
    } catch (Throwable) {
        $availablePetsCount = 3;
        $adoptedPetsCount = 1;
    }

    return view('welcome', compact('availablePetsCount', 'adoptedPetsCount'));
})->name('home');

Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show');

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

    // Adoption applications (adopters)
    Route::middleware('role:adopter')->group(function () {
        Route::post('/pets/{pet}/apply', [AdoptionApplicationController::class, 'store'])->name('applications.store');
        Route::get('/dashboard/requests', [DashboardController::class, 'requests'])->name('dashboard.requests');
        Route::get('/dashboard/my-pets', [DashboardController::class, 'myPets'])->name('dashboard.my-pets');
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

        Route::get('/reports/adoption', [ReportController::class, 'monthlyAdoption'])->name('reports.adoption');
    });

    // Veterinarian routes
    Route::middleware('role:veterinarian')->group(function () {
        Route::post('/checkups', [VetCheckupController::class, 'store'])->name('checkups.store');
    });
});
