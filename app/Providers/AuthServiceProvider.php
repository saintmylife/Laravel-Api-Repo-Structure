<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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
        $this->definePassportConfig();
        $this->defineSuperAdmin();
        $this->defineResetPasswordLink();
    }
    private function definePassportConfig()
    {
        Passport::routes(function ($router) {
            $router->forAccessTokens();
        });
        Passport::tokensExpireIn(now()->addMinutes(config('app-config.token.access.exp')));
        Passport::refreshTokensExpireIn(now()->addMinutes(config('app-config.token.refresh.exp')));
    }
    private function defineSuperAdmin()
    {
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            if (
                $user->hasRole(config('app-config.super_admin_role_name')) ||
                $user->hasRole('co-' . config('app-config.super_admin_role_name'))
            ) {
                return true;
            }
            return null;
        });
    }
    private function defineResetPasswordLink()
    {
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return config('app-config.url.reset_password') . '?token=' . $token;
            // return 'https://example.com/reset-password?token=' . $token;
        });
    }
}
