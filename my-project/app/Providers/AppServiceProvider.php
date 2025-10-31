<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

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
        // If a locale was stored in session (e.g. via /lang/{lang}), apply it here
        // so views and translations use the selected language. Accessing the
        // session during service provider boot can sometimes fail (console,
        // early requests), so guard it and fall back to the configured locale.
        try {
            $locale = null;
            if (function_exists('session')) {
                // session() helper may throw if session manager isn't available yet
                $locale = session('app_locale', null);
            }
        } catch (\Throwable $e) {
            $locale = null;
        }

        App::setLocale($locale ?? config('app.locale'));
    }
}
