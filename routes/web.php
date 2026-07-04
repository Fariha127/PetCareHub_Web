<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
