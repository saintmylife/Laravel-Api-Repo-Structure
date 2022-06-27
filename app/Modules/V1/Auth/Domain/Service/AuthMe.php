<?php

namespace App\Modules\V1\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;

class AuthMe extends BaseService
{
    public function __invoke(): Payload
    {
        return $this->newPayload(Payload::STATUS_FOUND, [
            'data' => auth()->user()
        ]);
    }
}
