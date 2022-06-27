<?php

namespace App\Console\Commands\Passport;

use Illuminate\Console\Command;

class PassportInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:secret';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Passport Client';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('generate:secret-client', [
            '--password' => true,
            '--provider' => 'users',
            '--name' => config('app-config.passport.client_name'),
            '--redirect_uri' => config('app.url')
        ]);
    }
}
