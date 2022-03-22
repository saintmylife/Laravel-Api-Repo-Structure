<?php

namespace App\Modules\Auth\Traits;

trait PassportConfig
{
    public function oAuthUrl()
    {
        $oAuthUrl = config('app.url');
        if (config('app.env') == 'local') {
            $oAuthUrl = \Str::finish($oAuthUrl, ':8001');
        }
        return $oAuthUrl . '/oauth/token';
    }
    public function oAuthFormData(string $grantType, array $data = null)
    {
        $form = [
            'grant_type' => $grantType,
            'client_id' => config('passport.personal_access_client.id'),
            'client_secret' => config('passport.personal_access_client.secret'),
            'scope' => '',
        ];
        if (!is_null($data)) {
            foreach ($data as $index => $value) {
                if (!isset($form[$index])) {
                    $form[$index] = $value;
                }
            }
        }
        return $form;
    }
}
