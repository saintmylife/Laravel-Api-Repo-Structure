<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        $this->registerRepository();
        $this->setDefaultRulePassword();
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
        date_default_timezone_set('Asia/Jakarta');
    }

    protected function setDefaultRulePassword()
    {
        Password::defaults(function () {
            return Password::min(6)->mixedCase()->numbers();
        });
    }
}
