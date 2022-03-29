<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::pattern('id', '[0-9]+');
            // api routing
            $this->mapApiRoutes();
            // web routing
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            // fallback
            Route::fallback(function () {
                return response()->json(['message' => 'Route Not Found!'], 404);
            })->name('fallback');
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $routeFiles = glob(base_path('routes/api/*.php'));
        foreach ($routeFiles as $routePath) {
            $fileName = basename($routePath, '.php');
            $namespace = sprintf('App\Modules\%s\Api\Action', Str::studly($fileName));
            Route::prefix('api')
                ->middleware(['api', 'auth:api'])
                ->namespace($namespace)
                ->group($routePath);
        }
    }
}
