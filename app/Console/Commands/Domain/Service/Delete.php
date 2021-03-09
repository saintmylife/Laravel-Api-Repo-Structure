<?php

namespace App\Console\Commands\Domain\Service;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class Delete extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:delete {name : Define Delete Module Name}';
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
    protected $type = 'Delete Service';
    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        if(Str::contains($name, 'Delete')){
            $name = Str::before($this->argument('name'), 'Delete');
        }
        $stub = parent::replaceClass($stub, $name);
        $stub = str_replace(['{{ arg_name }}'], $name, $stub);
        return str_replace(['{{ strtolower(arg_name) }}'], Str::lower($name), $stub);
    }
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $relativePath = '/../../stubs/Domain/Service/delete.stub';
        return __DIR__.$relativePath;
    }
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $name = $this->argument('name');
        if(Str::contains($name, 'Delete')){
            $name = Str::before($this->argument('name'), 'Delete');
        }
        return $rootNamespace.'\Modules\\'.$name.'\\Domain\Service';
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the Delete Service Files'],
        ];
    }
}
