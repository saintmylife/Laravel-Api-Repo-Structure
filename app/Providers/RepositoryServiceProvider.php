<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $dirName = [];
        $apiVersion = glob(__DIR__ . '/../Modules/V*', GLOB_ONLYDIR);
        foreach ($apiVersion as $version) {
            $baseVersion = basename($version);
            foreach (glob(__DIR__ . "/../Modules/${baseVersion}/*", GLOB_ONLYDIR) as $dir) {
                $dirName[$baseVersion][] = basename($dir);
            };
        }

        foreach ($dirName as $version => $moduleName) {
            foreach ($moduleName as $name) {
                $this->app->bind(
                    "App\\Modules\\{$version}\\{$name}\\Repository\\{$name}Repository",
                    "App\\Modules\\{$version}\\{$name}\\Repository\\{$name}RepositoryEloquent",
                );
            }
        }
    }
}
