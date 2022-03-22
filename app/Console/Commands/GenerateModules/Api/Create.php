<?php

namespace App\Console\Commands\GenerateModules\Api;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class Create extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:api-create';
    protected $hidden = true;
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'generate:api-create';
    // protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Create Api Action Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Api Create';
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/create.stub';
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

        $replace = [
            '{{ createApiNamespace }}' => $this->rootNamespace() . 'Modules\\' . $create . '\\Api\\Action',
            '{{ api }}' => $create
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

        return $this->laravel->basePath('app/Modules/') . $name . '/Api/Action/' . $name . 'CreateAction.php';
    }
}
