<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepository();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setAppLocale();
    }

    private function registerRepository()
    {
        $dirname = [];
        foreach (glob(__DIR__ . '/../Modules/*', GLOB_ONLYDIR) as $dir) {
            $dirname[] = basename($dir);
        }

        foreach ($dirname as $name) {
            $this->app->bind(
                "App\Modules\\{$name}\Repository\\{$name}RepoInterface",
                "App\Modules\\{$name}\Repository\\{$name}Eloquent"
            );
        }
    }
    /**
     * Set App Localization
     * @return void
     */
    private function setAppLocale()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
