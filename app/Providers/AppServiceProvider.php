<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Optional: Token lifetimes
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));

        // If you want to use personal access tokens
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
