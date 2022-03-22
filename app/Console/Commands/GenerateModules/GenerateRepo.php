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
                            {--i|interface : Generate Interface Resource}';

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
        if ($this->option('all')) {
            $this->input->setOption('eloquent', true);
            $this->input->setOption('interface', true);
        }

        if ($this->option('eloquent')) {
            $this->createEloquent();
        }
        if ($this->option('interface')) {
            $this->createInterface();
        }

        $this->info('All Repository Resources Created Successfully !!!');
        return 0;
    }

    /**
     * Create eloquent resources.
     *
     * @return void
     */
    protected function createEloquent()
    {
        $this->callSilently('generate:repo-eloquent', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
    /**
     * Create interface resource.
     *
     * @return void
     */
    protected function createInterface()
    {
        $this->callSilently('generate:repo-interface', [
            'name' => Str::studly($this->argument('name'))
        ]);
    }
}
