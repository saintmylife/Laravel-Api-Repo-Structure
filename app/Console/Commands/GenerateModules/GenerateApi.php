<?php

namespace App\Console\Commands\GenerateModules;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

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
                            {--r|responder : Generate Api Responder Module Resources}';

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
        if ($this->option('all')) {
            $this->input->setOption('create', true);
            $this->input->setOption('delete', true);
            $this->input->setOption('edit', true);
            $this->input->setOption('fetch', true);
            $this->input->setOption('list', true);
            $this->input->setOption('responder', true);
        }

        if ($this->option('create')) {
            $this->apiCreate();
        }
        if ($this->option('delete')) {
            $this->apiDelete();
        }
        if ($this->option('edit')) {
            $this->apiEdit();
        }
        if ($this->option('fetch')) {
            $this->apiFetch();
        }
        if ($this->option('list')) {
            $this->apiList();
        }
        if ($this->option('responder')) {
            $this->apiResponder();
        }
    }
    /**
     * Create a create api for the modules.
     *
     * @return void
     */
    protected function apiCreate()
    {
        $this->call('generate:api-create', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Create a delete api for the modules.
     *
     * @return void
     */
    protected function apiDelete()
    {
        $this->call('generate:api-delete', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Create a edit api for the modules.
     *
     * @return void
     */
    protected function apiEdit()
    {
        $this->call('generate:api-edit', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Create a fetch api for the modules.
     *
     * @return void
     */
    protected function apiFetch()
    {
        $this->call('generate:api-fetch', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Create a list api for the modules.
     *
     * @return void
     */
    protected function apiList()
    {
        $this->call('generate:api-list', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Create a responder api for the modules.
     *
     * @return void
     */
    protected function apiResponder()
    {
        $this->call('generate:api-responder', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate basic resources for this Module'],
            ['create', 'c', InputOption::VALUE_NONE, 'Create a new create api resources'],
            ['delete', 'd', InputOption::VALUE_NONE, 'Create a new delete api resources'],
            ['edit', 'e', InputOption::VALUE_NONE, 'Create a new edit api resources'],
            ['fetch', 'f', InputOption::VALUE_NONE, 'Create a new fetch api resources'],
            ['list', 'l', InputOption::VALUE_NONE, 'Create a new list api resources'],
            ['responder', 'r', InputOption::VALUE_NONE, 'Create a new responder api resources'],
        ];
    }
}
