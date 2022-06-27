<?php

namespace App\Console\Commands\GenerateModules;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:service {name : The Service Name}
                            {--all=default : Generate All Service Module Resources} 
                            {--c|create : Generate Create Service Module Resource} 
                            {--d|delete : Generate Delete Service Module Resource}
                            {--e|edit : Generate Edit Service Module Resource}
                            {--f|fetch : Generate Fetch Service Module Resource}
                            {--l|list : Generate List Service Module Resource}
                            {--rev|revision= : The Version Of The Module }
                            {--force : Force Rewrite The File}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a set of service module resources';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (is_null($this->option('revision'))) {
            $this->input->setOption('revision', config('app-config.version'));
        }
        if ($this->option('all')) {
            $this->input->setOption('create', true);
            $this->input->setOption('delete', true);
            $this->input->setOption('edit', true);
            $this->input->setOption('fetch', true);
            $this->input->setOption('list', true);
        }

        if ($this->option('create')) {
            $this->serviceCreate($this->option('revision'));
        }
        if ($this->option('delete')) {
            $this->serviceDelete($this->option('revision'));
        }
        if ($this->option('edit')) {
            $this->serviceEdit($this->option('revision'));
        }
        if ($this->option('fetch')) {
            $this->serviceFetch($this->option('revision'));
        }
        if ($this->option('list')) {
            $this->serviceList($this->option('revision'));
        }

        $this->info('All Service Resources Created Successfully !!!');
        return 0;
    }

    /**
     * Create service resources.
     *
     * @return void
     */
    protected function serviceCreate(int $version)
    {
        $this->callSilently('generate:service-create', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
    /**
     * Delete service resources.
     *
     * @return void
     */
    protected function serviceDelete(int $version)
    {
        $this->callSilently('generate:service-delete', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
    /**
     * Edit service resources.
     *
     * @return void
     */
    protected function serviceEdit(int $version)
    {
        $this->callSilently('generate:service-edit', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
    /**
     * Fetch service resources.
     *
     * @return void
     */
    protected function serviceFetch(int $version)
    {
        $this->callSilently('generate:service-fetch', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
    /**
     * List service resources.
     *
     * @return void
     */
    protected function serviceList(int $version)
    {
        $this->callSilently('generate:service-list', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
}
