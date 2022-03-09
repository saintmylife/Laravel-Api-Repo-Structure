<?php

namespace App\Modules\Auth\Domain\Service;

use App\Modules\Auth\Traits\PassportConfig;
use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Common\Domain\AuthPayload;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

/**
 * Auth logout service
 */
class AuthLogout extends BaseService
{
    use PassportConfig;
    private $tokenRepo;
    private $refreshTokenRepo;

    public function __construct(TokenRepository $tokenRepo, RefreshTokenRepository $refreshTokenRepo)
    {
        $this->tokenRepo = $tokenRepo;
        $this->refreshTokenRepo = $refreshTokenRepo;
    }
    public function __invoke(): Payload
    {
        $token = Auth::user()->token()->id;
        try {
            $this->tokenRepo->revokeAccessToken($token);
            $this->refreshTokenRepo->revokeRefreshTokensByAccessTokenId($token);
        } catch (\Exception) {
            return $this->newPayload(AuthPayload::STATUS_AUTH_TOKEN_INVALID);
        }
        return $this->newPayload(AuthPayload::STATUS_AUTH_LOGOUT);
    }
}
