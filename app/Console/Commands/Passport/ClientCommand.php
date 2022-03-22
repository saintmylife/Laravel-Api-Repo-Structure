<?php

namespace App\Console\Commands\Passport;

use Illuminate\Console\Command;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;

class ClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:secret-client
            {--personal : Create a personal access token client}
            {--password : Create a password grant client}
            {--client : Create a client credentials grant client}
            {--name= : The name of the client}
            {--provider= : The name of the user provider}
            {--redirect_uri= : The URI to redirect to after authorization }
            {--user_id= : The user ID the client should be assigned to }
            {--public : Create a public client (Auth code grant type only) }';
    protected $hidden = true;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a client for issuing access tokens';

    /**
     * Execute the console command.
     *
     * @param  \Laravel\Passport\ClientRepository  $clients
     * @return void
     */
    public function handle(ClientRepository $clients)
    {
        if ($this->option('personal')) {
            $this->createPersonalClient($clients);
        } elseif ($this->option('password')) {
            $this->createPasswordClient($clients);
        } elseif ($this->option('client')) {
            $this->createClientCredentialsClient($clients);
        } else {
            $this->createAuthCodeClient($clients);
        }
    }

    /**
     * Create a new personal access client.
     *
     * @param  \Laravel\Passport\ClientRepository  $clients
     * @return void
     */
    protected function createPersonalClient(ClientRepository $clients)
    {
        $name = $this->option('name') ?: $this->ask(
            'What should we name the personal access client?',
            config('app.name') . ' Personal Access Client'
        );

        $client = $clients->createPersonalAccessClient(
            null,
            $name,
            'http://localhost'
        );

        $this->info('Personal access client created successfully.');

        $this->outputClientDetails($client);
    }

    /**
     * Create a new password grant client.
     *
     * @param  \Laravel\Passport\ClientRepository  $clients
     * @return void
     */
    protected function createPasswordClient(ClientRepository $clients)
    {
        $name = $this->option('name') ?: $this->ask(
            'What should we name the password grant client?',
            config('app.name') . ' Password Grant Client'
        );

        $providers = array_keys(config('auth.providers'));

        $provider = $this->option('provider') ?: $this->choice(
            'Which user provider should this client use to retrieve users?',
            $providers,
            in_array('users', $providers) ? 'users' : null
        );

        $client = $clients->createPasswordGrantClient(
            null,
            $name,
            'http://localhost',
            $provider
        );

        $this->info('Password grant client created successfully.');

        $this->outputClientDetails($client);
        $this->setEnvKey('PASSPORT_PERSONAL_ACCESS_CLIENT_ID', $client->id);
        $this->setEnvKey('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET', $client->plainSecret);
    }
    protected function setEnvKey($key, $value)
    {
        $envFilePath = app()->environmentFilePath();
        $content = file_get_contents($envFilePath);
        [$newEnvFileContent, $isNewVariableSet] = $this->setEnvVariable($content, $key, $value);

        if ($isNewVariableSet) {
            $this->info("A new environment variable with key '{$key}' has been set to '{$value}'");
        } else {
            [$_, $oldValue] = explode('=', $this->readKeyValuePair($content, $key), 2);
            $this->info("Environment variable with key '{$key}' has been changed from '{$oldValue}' to '{$value}'");
        }
        $this->writeFile($envFilePath, $newEnvFileContent);
    }
    /**
     * Set or update env-variable.
     *
     * @param string $envFileContent Content of the .env file.
     * @param string $key            Name of the variable.
     * @param string $value          Value of the variable.
     *
     * @return array [string newEnvFileContent, bool isNewVariableSet].
     */
    public function setEnvVariable(string $envFileContent, string $key, string $value): array
    {
        $oldPair = $this->readKeyValuePair($envFileContent, $key);

        // Wrap values that have a space or equals in quotes to escape them
        if (preg_match('/\s/', $value) || strpos($value, '=') !== false) {
            $value = '"' . $value . '"';
        }

        $newPair = $key . '=' . $value;

        // For existed key.
        if ($oldPair !== null) {
            $replaced = preg_replace('/^' . preg_quote($oldPair, '/') . '$/uimU', $newPair, $envFileContent);
            return [$replaced, false];
        }

        // For a new key.
        return [$envFileContent . "\n" . $newPair . "\n", true];
    }
    /**
     * Read the "key=value" string of a given key from an environment file.
     * This function returns original "key=value" string and doesn't modify it.
     *
     * @param string $envFileContent
     * @param string $key
     *
     * @return string|null Key=value string or null if the key is not exists.
     */
    public function readKeyValuePair(string $envFileContent, string $key): ?string
    {
        // Match the given key at the beginning of a line
        if (preg_match("#^ *{$key} *= *[^\r\n]*$#uimU", $envFileContent, $matches)) {
            return $matches[0];
        }

        return null;
    }
    /**
     * Overwrite the contents of a file.
     *
     * @param string $path
     * @param string $contents
     *
     * @return boolean
     */
    protected function writeFile(string $path, string $contents): bool
    {
        return (bool)file_put_contents($path, $contents, LOCK_EX);
    }

    /**
     * Create a client credentials grant client.
     *
     * @param  \Laravel\Passport\ClientRepository  $clients
     * @return void
     */
    protected function createClientCredentialsClient(ClientRepository $clients)
    {
        $name = $this->option('name') ?: $this->ask(
            'What should we name the client?',
            config('app.name') . ' ClientCredentials Grant Client'
        );

        $client = $clients->create(
            null,
            $name,
            ''
        );

        $this->info('New client created successfully.');

        $this->outputClientDetails($client);
    }

    /**
     * Create a authorization code client.
     *
     * @param  \Laravel\Passport\ClientRepository  $clients
     * @return void
     */
    protected function createAuthCodeClient(ClientRepository $clients)
    {
        $userId = $this->option('user_id') ?: $this->ask(
            'Which user ID should the client be assigned to?'
        );

        $name = $this->option('name') ?: $this->ask(
            'What should we name the client?'
        );

        $redirect = $this->option('redirect_uri') ?: $this->ask(
            'Where should we redirect the request after authorization?',
            url('/auth/callback')
        );

        $client = $clients->create(
            $userId,
            $name,
            $redirect,
            null,
            false,
            false,
            !$this->option('public')
        );

        $this->info('New client created successfully.');

        $this->outputClientDetails($client);
    }

    /**
     * Output the client's ID and secret key.
     *
     * @param  \Laravel\Passport\Client  $client
     * @return void
     */
    protected function outputClientDetails(Client $client)
    {
        if (Passport::$hashesClientSecrets) {
            $this->line('<comment>Here is your new client secret. This is the only time it will be shown so don\'t lose it!</comment>');
            $this->line('');
        }

        $this->line('<comment>Client ID:</comment> ' . $client->id);
        $this->line('<comment>secret:</comment> ' . $client->plainSecret);
    }
}
