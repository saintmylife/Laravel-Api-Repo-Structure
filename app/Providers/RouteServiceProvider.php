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
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->globalRouteConstraints();
            $this->mapApiRoute();
            Route::middleware('web')->group(base_path('routes/web.php'));
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
     * Configure Global Constraint for route parameters
     * 
     * @return void
     */
    protected function globalRouteConstraints()
    {
        Route::pattern('id', '[0-9]+');
    }
    /**
     * Register api/private Route
     * 
     * @return void
     */
    protected function mapApiRoute()
    {
        $getApiVersion = glob(base_path('routes/api/v*'));
        foreach ($getApiVersion as $api) {
            $version = basename($api);
            $routes = glob(base_path("routes/api/$version/*.php"));
            $middleware = ['api', 'api_version:' . $version];
            $prefix = "api/${version}";
            foreach ($routes as $route) {
                $fileName = basename($route, '.php');
                $namespace = sprintf('App\Modules\%s\%s\Api\Action', $version, Str::studly($fileName));
                Route::prefix($prefix)
                    ->middleware($middleware)
                    ->namespace($namespace)
                    ->name("{$version}.")
                    ->group($route);
            }
        }
    }
}
