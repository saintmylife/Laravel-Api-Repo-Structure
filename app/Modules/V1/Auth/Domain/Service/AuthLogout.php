<?php

namespace App\Modules\V1\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class AuthLogout extends BaseService
{
    public function __construct(private TokenRepository $accessToken, private RefreshTokenRepository $refreshToken)
    {
    }

    public function __invoke(): Payload
    {
        $this->accessToken->revokeAccessToken(auth()->user()->token()->id);
        $this->refreshToken->revokeRefreshTokensByAccessTokenId(auth()->user()->token()->id);
        cookie()->queue(cookie()->forget(config('app-config.token.access.name')));
        cookie()->queue(cookie()->forget(config('app-config.token.refresh.name')));

        return $this->newPayload(Payload::STATUS_AUTH_LOGGED_OUT);
    }
}
