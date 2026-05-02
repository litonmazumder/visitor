<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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

    public function boot()
    {
         if (app()->environment('production')) {
            URL::forceScheme('https');
        }
        $this->loadMigrationsFrom([
            database_path('migrations/employee'),
            database_path('migrations/visitor'),
        ]);
    }
}
