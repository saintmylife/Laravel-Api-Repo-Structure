<?php

namespace App\Modules\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use Illuminate\Support\Facades\Auth;

/**
 * Auth logout service
 */
class AuthLogout extends BaseService
{
    public function __invoke(): Payload
    {
        Auth::logout();
        $message = 'Successfully logged out';
        return $this->newPayload(Payload::STATUS_LOGOUT, compact('message'));
    }
}
