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

    public function boot()
    {
        $this->loadMigrationsFrom([
            database_path('migrations/employee'),
            database_path('migrations/visitor'),
        ]);
    }
}
