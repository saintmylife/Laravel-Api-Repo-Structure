<?php

namespace App\Console\Commands\GenerateModules\Api;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class Custom extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:api-custom';
    protected $hidden = true;
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'generate:api-custom';
    // protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Custom Api Action Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Api Custom';
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
        $create = class_basename($name);
        $namespace = class_basename($this->argument('namespace'));

        $replace = [
            '{{ createApiNamespace }}' => $this->rootNamespace() . 'Modules\\' . Str::studly($namespace) . '\\Api\\Action',
            '{{ api }}' => $create,
            '{{ pathNamespace }}' => Str::studly($namespace)
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
        $namespace = (string) Str::of($this->argument('namespace'))->replaceFirst($this->rootNamespace(), '');

        return $this->laravel->basePath('app/Modules/') . Str::studly($namespace) . '/Api/Action/' . $name . 'Action.php';
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
            ['namespace', InputArgument::REQUIRED, 'The namespace of the class'],
        ];
    }
}
