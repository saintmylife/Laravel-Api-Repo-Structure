<?php

namespace App\Console\Commands\GenerateModules\Service;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class Custom extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:service-custom';
    protected $hidden = true;
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'generate:service-custom';
    // protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Custom Service Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service Custom';
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/custom.stub';
    }
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $custom = class_basename($name);

        $replace = [
            '{{ customServiceNamespace }}' => $this->rootNamespace() . 'Modules\\' . $custom . '\\Domain\\Service',
            '{{ service }}' => $custom,
            '{{service}}' => Str::camel($custom)
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

        return $this->laravel->basePath('app/Modules/') . $name . '/Domain/Service/' . $name . '.php';
    }
}
