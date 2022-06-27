<?php

namespace App\Modules\V1\Auth\Domain\Service\Utilities;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthProxy
{
    public function grantPasswordToken(array $credentials)
    {
        $params = [
            'grant_type' => 'password',
            'username' => $credentials['username'],
            'password' => $credentials['password'],
            'client_id' => $credentials['client_id']
        ];
        return $this->proxyRequest($params);
    }
    public function refreshAccessToken(array $credentials)
    {
        $refreshToken = request()->cookie(config('app-config.token.refresh.name'));
        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $credentials['client_id']
        ];
        return $this->proxyRequest($params);
    }

    protected function proxyRequest(array $params)
    {
        $request = Http::asForm()->post(config('app.url') . '/oauth/token', array_merge([
            'client_id' => $params['client_id'],
            'client_secret' => $client ?? config('app-config.passport.secret'),
        ], $params));
        if (!$request->ok()) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/proxy.log'),
            ])->info(json_encode($request->body()));
            throw new \Exception($request->json()['message']);
        }
        $this->setHttpOnlyCookie($request->json());
        return $request->json()['access_token'];
    }
    protected function setHttpOnlyCookie(array $params)
    {
        cookie()->queue(
            config('app-config.token.access.name'), // name
            $params['access_token'], // value
            config('app-config.token.access.exp'), // minutes
            // null, // path
            // null, // domain
            // false, // secure
            // true // httponly
        );
        cookie()->queue(
            config('app-config.token.refresh.name'), // name
            $params['refresh_token'], // value
            config('app-config.token.refresh.exp'), // minutes
            // null, // path
            // null, // domain
            // false, // secure
            // true // httponly
        );
    }
}
