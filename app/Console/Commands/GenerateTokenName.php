<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class GenerateTokenName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:name {name : Define Token Name}
        {--s|show : Display the token name instead of modifying files.}
        {--always-no=default : Skip generating token name if it already exists.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the JWTAuth token name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tokenName = Str::upper(Str::slug($this->argument('name')));
        if (file_exists($path = $this->envPath()) === false) {
            return $this->comment('no .env file');
        }

        if (
            Str::contains(file_get_contents($path), 'ACCESS_TOKEN_NAME') === false &&
            Str::contains(file_get_contents($path), 'REFRESH_TOKEN_NAME') === false
        ) {
            file_put_contents($path, PHP_EOL . "ACCESS_TOKEN_NAME=$tokenName-AT" . PHP_EOL, FILE_APPEND);
            file_put_contents($path, PHP_EOL . "REFRESH_TOKEN_NAME=$tokenName-RT" . PHP_EOL, FILE_APPEND);
        } else {
            if (empty(config('app.access_token_name')) && empty(config('app.refresh_token_name'))) {
                file_put_contents($path, str_replace(
                    'ACCESS_TOKEN_NAME=',
                    "ACCESS_TOKEN_NAME=$tokenName-AT",
                    file_get_contents($path)
                ));
                file_put_contents($path, str_replace(
                    'REFRESH_TOKEN_NAME=',
                    "REFRESH_TOKEN_NAME=$tokenName-RT",
                    file_get_contents($path)
                ));
            } else {
                $this->comment('Token name already exists. Skipping...');
                return;
            }
        }

        $this->info("Token name $tokenName set successfully.");
    }

    /**
     * Get the .env file path.
     *
     * @return string
     */
    protected function envPath()
    {
        if (method_exists($this->laravel, 'environmentFilePath')) {
            return $this->laravel->environmentFilePath();
        }

        // check if laravel version Less than 5.4.17
        if (version_compare($this->laravel->version(), '5.4.17', '<')) {
            return $this->laravel->basePath() . DIRECTORY_SEPARATOR . '.env';
        }

        return $this->laravel->basePath('.env');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the token'],
        ];
    }
}
