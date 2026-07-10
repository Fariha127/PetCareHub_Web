<?php

namespace App\Providers;

use App\Models\AdoptionApplication;
use App\Observers\AdoptionApplicationObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        AdoptionApplication::observe(AdoptionApplicationObserver::class);
    }
}
