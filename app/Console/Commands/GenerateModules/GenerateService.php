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
                            {--a|all : Generate All Service Module Resources} 
                            {--c|create : Generate Create Service Module Resource} 
                            {--d|delete : Generate Delete Service Module Resource}
                            {--e|edit : Generate Edit Service Module Resource}
                            {--f|fetch : Generate Fetch Service Module Resource}
                            {--l|list : Generate List Service Module Resource}';

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
        if ($this->option('all')) {
            $this->input->setOption('create', true);
            $this->input->setOption('delete', true);
            $this->input->setOption('edit', true);
            $this->input->setOption('fetch', true);
            $this->input->setOption('list', true);
        }

        if ($this->option('create')) {
            $this->serviceCreate();
        }
        if ($this->option('delete')) {
            $this->serviceDelete();
        }
        if ($this->option('edit')) {
            $this->serviceEdit();
        }
        if ($this->option('fetch')) {
            $this->serviceFetch();
        }
        if ($this->option('list')) {
            $this->serviceList();
        }

        $this->info('All Service Resources Created Successfully !!!');
        return 0;
    }

    /**
     * Create service resources.
     *
     * @return void
     */
    protected function serviceCreate()
    {
        $this->callSilently('generate:service-create', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Delete service resources.
     *
     * @return void
     */
    protected function serviceDelete()
    {
        $this->callSilently('generate:service-delete', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Edit service resources.
     *
     * @return void
     */
    protected function serviceEdit()
    {
        $this->callSilently('generate:service-edit', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Fetch service resources.
     *
     * @return void
     */
    protected function serviceFetch()
    {
        $this->callSilently('generate:service-fetch', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * List service resources.
     *
     * @return void
     */
    protected function serviceList()
    {
        $this->callSilently('generate:service-list', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
}
