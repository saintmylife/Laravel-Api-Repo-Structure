<?php

namespace App\Console\Commands\GenerateModules;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateRepo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:repo {name : The Repo Name} 
                            {--a|all=default : Generate All Module Resources} 
                            {--e|eloquent : Generate Eloquent Resource} 
                            {--i|interface : Generate Interface Resource}
                            {--rev|revision= : The Version Of The Module }
                            {--force : Force Rewrite The File}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a set of repository resources';

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
            $this->input->setOption('eloquent', true);
            $this->input->setOption('interface', true);
        }

        if ($this->option('eloquent')) {
            $this->createEloquent($this->option('revision'));
        }
        if ($this->option('interface')) {
            $this->createInterface($this->option('revision'));
        }

        $this->info('All Repository Resources Created Successfully !!!');
        return 0;
    }

    /**
     * Create eloquent resources.
     *
     * @return void
     */
    protected function createEloquent(int $version)
    {
        $this->callSilently('generate:repo-eloquent', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
    /**
     * Create interface resource.
     *
     * @return void
     */
    protected function createInterface(int $version)
    {
        $this->callSilently('generate:repo-interface', [
            'name' => Str::studly($this->argument('name')),
            '--revision' => $version,
            '--force' => $this->option('force')
        ]);
    }
}
