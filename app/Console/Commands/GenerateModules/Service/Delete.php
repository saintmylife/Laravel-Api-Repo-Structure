<?php

namespace App\Console\Commands\GenerateModules\Service;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class Delete extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:service-delete';
    protected $hidden = true;
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'generate:service-delete';
    // protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Delete Service Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service Delete';
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/delete.stub';
    }
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $delete = class_basename($name);
        $version = "V{$this->option('revision')}";
        $namespace = "Modules\\{$version}\\{$delete}\\Domain\\Service";
        $replace = [
            '{$deleteServiceNamespace}' => $this->rootNamespace() . $namespace,
            '{$service}' => $delete,
            '{$serviceCamel}' => Str::camel($delete),
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
        $path = "/app/Modules/v{$this->option('revision')}/{$name}/Domain/Service/{$name}Delete.php";

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
