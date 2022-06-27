<?php

namespace App\Console\Commands\GenerateModules\Service;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class Create extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:service-create';
    protected $hidden = true;
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'generate:service-create';
    // protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Create Service Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service Create';
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
        $version = "V{$this->option('revision')}";
        $namespace = "Modules\\{$version}\\{$create}\\Domain\\Service";
        $replace = [
            '{$createServiceNamespace}' => $this->rootNamespace() . $namespace,
            '{$service}' => $create,
            '{$serviceCamel}' => Str::camel($create),
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
        $version = "v{$this->option('revision')}";
        $path = "/app/Modules/{$version}/{$name}/Domain/Service/{$name}Create.php";

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
