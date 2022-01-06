<?php

namespace App\Modules\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use Illuminate\Support\Facades\Auth;

/**
 * Auth profile
 */
class AuthProfile extends BaseService
{
    public function __invoke()
    {
        $data = Auth::user();
        $data->getPermissionsViaRoles();
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
