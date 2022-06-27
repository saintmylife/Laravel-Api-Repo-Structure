<?php

namespace App\Console\Commands\GenerateModules;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

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

        $version = "V{$this->option('revision')}";
        $namespace = "Modules\\{$version}\\{$filter}\\Domain";
        $replace = [
            '{$filterNamespace}' => $this->rootNamespace() . $namespace,
            '{$filter}' => $filter,
            '{$filterLower}' => Str::lower($filter),
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
        $path = "/app/Modules/v{$this->option('revision')}/{$name}/Domain/{$name}Filter.php";

        return $this->laravel->basePath() . $path;
    }
    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force Rewrite File'],
            ['revision', 'r', InputOption::VALUE_REQUIRED, 'Version Resource Module', config('app-config.version')],
        ];
    }
}
