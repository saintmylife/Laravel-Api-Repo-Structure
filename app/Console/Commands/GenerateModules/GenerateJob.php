<?php

namespace App\Console\Commands\GenerateModules;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateJob extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:job';
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'generate:job';
    // protected $hidden = true;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Job Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Job Module';
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/job.stub';
    }
    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $job = class_basename($name);
        $module = \Str::studly($this->argument('module'));
        $version = "V{$this->option('revision')}";
        $namespace = "Modules\\{$version}\\{$module}\\Domain\\Jobs";
        $replace = [
            '{$jobNamespace}' => $this->rootNamespace() . $namespace,
            '{$job}' => $job,
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
        if (!$this->option('revision')) {
            $this->input->setOption('revision', $this->ask('What version of the module ?', config('app-config.version')));
        }
        $path = "/app/Modules/V{$this->option('revision')}/{$this->argument('module')}/Domain/Jobs/{$name}.php";
        return $this->laravel->basePath() . $path;
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        $args = parent::getArguments();
        array_push($args, ['module', InputArgument::REQUIRED, 'The module name of the job for repository binding']);
        return $args;
    }
    protected function getOptions()
    {
        return [
            ['revision', 'r', InputOption::VALUE_NONE, 'Version Resource Module'],
        ];
    }
}
