<?php

namespace App\Providers;

use App\Domain\Application\Model\Application;
use App\Services\Auth\AuthorizationTokenGuard;
use App\Policies\ApplicationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         Application::class => ApplicationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('eloquent_api', function($app, array $config) {
            return new EloquentAPIAuthorizationProvider($app['hash'], $config['model']);
        });

        Auth::extend('api_token', function ($app, $name, array $config) {
            return new AuthorizationTokenGuard(Auth::createUserProvider($config['provider']), request());
        });
    }
}
