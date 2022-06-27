<?php

namespace App\Console\Commands\GenerateModules;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:module {name : The Module Name} 
                            {--A|all=default : Generate All Module Resources} 
                            {--a|api : Generate Api Module Resources} 
                            {--dt|dto : Generate Dto Module Resource}
                            {--ft|filter : Generate Filter Module Resource}
                            {--r|repo : Generate Repository Module Resources}
                            {--s|svc : Generate Service Module Resources}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a set of module resources';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $moduleVersion = $this->ask('What version of the module ?', config('app-config.version'));

        if ($this->option('all')) {
            $this->input->setOption('api', true);
            $this->input->setOption('dto', true);
            $this->input->setOption('filter', true);
            $this->input->setOption('repo', true);
            $this->input->setOption('svc', true);
        }

        if ($this->option('api')) {
            $this->createApi($moduleVersion);
        }
        if ($this->option('dto')) {
            $this->createDto($moduleVersion);
        }
        if ($this->option('filter')) {
            $this->createFilter($moduleVersion);
        }
        if ($this->option('repo')) {
            $this->createRepo($moduleVersion);
        }
        if ($this->option('svc')) {
            $this->createService($moduleVersion);
        }

        $this->info('All Module Resources Created Successfully !!!');
        return 0;
    }

    /**
     * Create api resources.
     *
     * @return void
     */
    protected function createApi(int $version)
    {
        $this->callSilently('generate:api', [
            'name' => Str::studly($this->argument('name')),
            '--all',
            '--revision' => $version
        ]);
    }
    /**
     * Create dto resources.
     *
     * @return void
     */
    protected function createDto(int $version)
    {
        $this->callSilently('generate:dto', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version
        ]);
    }
    /**
     * Create filter resource.
     *
     * @return void
     */
    protected function createFilter(int $version)
    {
        $this->callSilently('generate:filter', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version
        ]);
    }
    /**
     * Create repo resource.
     *
     * @return void
     */
    protected function createRepo(int $version)
    {
        $this->callSilently('generate:repo', [
            '--all',
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version
        ]);
    }
    /**
     * Create service resource.
     *
     * @return void
     */
    protected function createService(int $version)
    {
        $this->callSilently('generate:service', [
            'name' => Str::studly($this->argument('name')),
            '--all' => true,
            '--revision' => $version
        ]);
    }
}
