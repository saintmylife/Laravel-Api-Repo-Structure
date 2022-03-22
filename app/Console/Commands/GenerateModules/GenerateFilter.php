<?php

namespace App\Console\Commands\GenerateModules;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GenerateFilter extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:filter';
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'generate:filter';
    // protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Filter Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Filter';
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/filter.stub';
    }
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $filter = class_basename($name);

        $replace = [
            '{{ filterNamespace }}' => $this->rootNamespace() . 'Modules\\' . $filter . '\\Domain',
            '{{ filter }}' => $filter,
            '{{filter}}' => Str::lower($filter),
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

        return $this->laravel->basePath('app/Modules/') . $name . '/Domain/' . $name . 'Filter.php';
    }
}
