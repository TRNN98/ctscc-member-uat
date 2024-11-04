<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Route::prefix('api/v2')->group(function () {
            Passport::routes();
        });

        \Illuminate\Support\Facades\Auth::provider('customuserprovider', function ($app, array $config) {
            return new CustomUserProvider($app['hash'], $config['model']);
        });

        //

        // Passport::tokensExpireIn(now()->addMinute(15));
        Passport::tokensExpireIn(now()->addMinute(45));

        Passport::refreshTokensExpireIn(now()->addDays(60));
    }
}
