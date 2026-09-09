<?php

namespace App\Providers;

use App\Models\Profile;
use Illuminate\Support\Facades\View;
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
        // The header and footer need the profile on every page, including any
        // page added later that doesn't go through HomeController.
        View::composer(['layouts.*', 'partials.*'], function ($view) {
            $view->with('profile', Profile::current());
        });
    }
}
