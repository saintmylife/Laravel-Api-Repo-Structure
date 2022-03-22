<?php

namespace App\Modules\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;

class AuthProfile extends BaseService
{
    public function __invoke(): Payload
    {
        $data = auth()->user();
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
