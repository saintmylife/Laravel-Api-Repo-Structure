<?php

namespace App\Console\Commands\GenerateModules;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:api {name : The Api Module Name} 
                            {--all=default : Generate All Module Resources} 
                            {--c|create : Generate Api Create Module Resources} 
                            {--d|delete : Generate Api Delete Module Resources}
                            {--e|edit : Generate Api Edit Module Resources}
                            {--f|fetch : Generate Api Fetch Module Resources}
                            {--l|list : Generate Api List Module Resources}
                            {--r|responder : Generate Api Responder Module Resources}
                            {--rev|revision= : The Version Of The Module }
                            {--force : Force Rewrite The File}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a set of Api module resources';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Api Module';

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
            $this->input->setOption('responder', true);
        }

        if ($this->option('create')) {
            $this->apiCreate($this->option('revision'));
        }
        if ($this->option('delete')) {
            $this->apiDelete($this->option('revision'));
        }
        if ($this->option('edit')) {
            $this->apiEdit($this->option('revision'));
        }
        if ($this->option('fetch')) {
            $this->apiFetch($this->option('revision'));
        }
        if ($this->option('list')) {
            $this->apiList($this->option('revision'));
        }
        if ($this->option('responder')) {
            $this->apiResponder($this->option('revision'));
        }
    }
    /**
     * Create a create api for the modules.
     *
     * @return void
     */
    protected function apiCreate(int $version)
    {
        $this->call('generate:api-create', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
    /**
     * Create a delete api for the modules.
     *
     * @return void
     */
    protected function apiDelete(int $version)
    {
        $this->call('generate:api-delete', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
    /**
     * Create a edit api for the modules.
     *
     * @return void
     */
    protected function apiEdit(int $version)
    {
        $this->call('generate:api-edit', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
    /**
     * Create a fetch api for the modules.
     *
     * @return void
     */
    protected function apiFetch(int $version)
    {
        $this->call('generate:api-fetch', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
    /**
     * Create a list api for the modules.
     *
     * @return void
     */
    protected function apiList(int $version)
    {
        $this->call('generate:api-list', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
    /**
     * Create a responder api for the modules.
     *
     * @return void
     */
    protected function apiResponder(int $version)
    {
        $this->call('generate:api-responder', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
}
