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
        if ($this->option('all')) {
            $this->input->setOption('api', true);
            $this->input->setOption('dto', true);
            $this->input->setOption('filter', true);
            $this->input->setOption('repo', true);
            $this->input->setOption('svc', true);
        }

        if ($this->option('api')) {
            $this->createApi();
        }
        if ($this->option('dto')) {
            $this->createDto();
        }
        if ($this->option('filter')) {
            $this->createFilter();
        }
        if ($this->option('repo')) {
            $this->createRepo();
        }
        if ($this->option('svc')) {
            $this->createService();
        }

        $this->info('All Module Resources Created Successfully !!!');
        return 0;
    }

    /**
     * Create api resources.
     *
     * @return void
     */
    protected function createApi()
    {
        $this->callSilently('generate:api', [
            '--all',
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Create dto resources.
     *
     * @return void
     */
    protected function createDto()
    {
        $this->callSilently('generate:dto', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Create filter resource.
     *
     * @return void
     */
    protected function createFilter()
    {
        $this->callSilently('generate:filter', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Create repo resource.
     *
     * @return void
     */
    protected function createRepo()
    {
        $this->callSilently('generate:repo', [
            '--all',
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Create service resource.
     *
     * @return void
     */
    protected function createService()
    {
        $this->callSilently('generate:service', [
            '--all' => true,
            'name' => Str::studly($this->argument('name'))
        ]);
    }
}
