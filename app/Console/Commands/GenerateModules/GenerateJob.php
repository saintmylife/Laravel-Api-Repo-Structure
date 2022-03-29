<?php

namespace App\Console\Commands\GenerateModules;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Arr;
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
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && !$this->option('force')) {
            return false;
        }
    }
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
        $module = $this->argument('module');

        $replace = [
            '{{ jobNamespace }}' => $this->rootNamespace() . 'Modules\\' . $module . '\\Jobs',
            '{{ job }}' => $job,
            '{{ repoNamespace }}' => $this->rootNamespace() . 'Modules\\' . $module . '\\Repository\\' . $module . 'RepoInterface',
            '{{ repo }}' => $module
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

        return $this->laravel->basePath('app/Modules/') . $this->argument('module') . '/Jobs/' . $name . '.php';
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
}
