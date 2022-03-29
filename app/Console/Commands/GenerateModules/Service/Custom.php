<?php

namespace App\Console\Commands\GenerateModules\Service;

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
    protected $name = 'generate:service-custom';
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'generate:service-custom';
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
        $this->callSilently('generate:api-custom', [
            'name' => Str::studly($this->argument('name')),
            'namespace' => Str::studly($this->argument('namespace')),
        ]);

        $custom = class_basename($name);
        $customNamespace = class_basename($this->argument('namespace'));

        $replace = [
            '{{ customServiceNamespace }}' => $this->rootNamespace() . 'Modules\\' . Str::studly($customNamespace) . '\\Domain\\Service',
            '{{ service }}' => $custom,
            '{{service}}' => Str::camel($custom),
            '{{ pathNamespace }}' => Str::studly($customNamespace),
            '{{pathNamespace}}' => Str::camel($customNamespace)
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

        return $this->laravel->basePath('app/Modules/') . Str::studly($namespace) . '/Domain/Service/' . $name . '.php';
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
