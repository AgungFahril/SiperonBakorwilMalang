<?php

namespace App\Providers;

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
        try {
            $settings = \App\Models\Setting::pluck('value', 'key')->all();
            \Illuminate\Support\Facades\View::share('settings', $settings);
        } catch (\Exception $e) {
            // Ignore if tables are not migrated yet
        }
    }
}
