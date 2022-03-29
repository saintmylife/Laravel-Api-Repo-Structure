<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Passport Config
        Passport::routes();
        Passport::tokensExpireIn(now()->addMinutes(config('app-auth.access_token_exp')));
        Passport::refreshTokensExpireIn(now()->addMinutes(config('app-auth.refresh_token_exp')));

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole(config('app-auth.super_admin_role_name')) ? true : null;
        });
        // check model owner
        Gate::define('owner', function ($user, $modelId) {
            return $user->id == $modelId;
        });
    }
}
