<?php

namespace App\Modules\V1\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\AuthDto;
use App\Modules\V1\Auth\Domain\Service\Utilities\AuthProxy;

class AuthRefresh extends BaseService
{
    public function __construct(private AuthProxy $proxy)
    {
    }

    public function __invoke(): Payload
    {
        try {
            $token = $this->proxy->refreshAccessToken((new AuthDto)->getData());
        } catch (\Exception) {
            return $this->newPayload(Payload::STATUS_AUTH_EXPIRED);
        }
        return $this->newPayload(Payload::STATUS_AUTH_LOGGED_IN, compact('token'));
    }
}
