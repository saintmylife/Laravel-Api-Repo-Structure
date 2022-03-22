<?php

namespace App\Console\Commands\GenerateModules\Repository;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class Eloquent extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:repo-eloquent';
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'generate:repo-eloquent';
    protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Repository Eloquent Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository Eloquent';
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/eloquent.stub';
    }
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $eloquent = class_basename($name);

        $replace = [
            '{{ eloquentNamespace }}' => $this->rootNamespace() . 'Modules\\' . $eloquent . '\\Repository',
            '{{ eloquent }}' => $eloquent
        ];

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }
    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = (string) Str::of($name)->replaceFirst($this->rootNamespace(), '');

        return $this->laravel->basePath('app/Modules/') . $name . '/Repository/' . $name . 'Eloquent.php';
    }
}
