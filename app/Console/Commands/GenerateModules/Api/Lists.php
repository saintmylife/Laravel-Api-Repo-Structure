<?php

namespace App\Console\Commands\GenerateModules\Api;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class Lists extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:api-list';
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'generate:api-list';
    protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate List Api Action Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Api List';
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/list.stub';
    }
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $list = class_basename($name);

        $replace = [
            '{{ listApiNamespace }}' => $this->rootNamespace() . 'Modules\\' . $list . '\\Api\\Action',
            '{{ api }}' => $list
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

        return $this->laravel->basePath('app/Modules/') . $name . '/Api/Action/' . $name . 'ListAction.php';
    }
}
