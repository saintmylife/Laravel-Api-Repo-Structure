<?php

namespace App\Modules\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Common\Domain\AuthPayload;
use Illuminate\Support\Facades\Auth;

/**
 * Auth logout service
 */
class AuthLogout extends BaseService
{
    public function __invoke(): Payload
    {
        Auth::logout();
        return $this->newPayload(AuthPayload::STATUS_AUTH_LOGOUT);
    }
}
