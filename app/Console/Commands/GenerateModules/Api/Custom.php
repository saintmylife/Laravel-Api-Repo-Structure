<?php

namespace App\Console\Commands\GenerateModules\Api;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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
        $baseNamespace = class_basename($this->argument('namespace'));
        $version = "V{$this->option('revision')}";
        $namespace = "Modules\\{$version}\\" . Str::studly($baseNamespace) . "\\Api\\Action";
        $replace = [
            '{$createApiNamespace}' => $this->rootNamespace() . $namespace,
            '{$api}' => $create,
            '{$pathNamespace}' => Str::studly($baseNamespace),
            '{$version}' => $version
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
        $version = "v{$this->option('revision')}";
        $path = "/app/Modules/{$version}/" . Str::studly($namespace) . "/Api/Action/{$name}Action.php";

        return $this->laravel->basePath() . $path;
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
