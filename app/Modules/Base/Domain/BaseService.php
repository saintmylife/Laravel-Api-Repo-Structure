<?php

namespace App\Modules\Base\Domain;

use App\Modules\Common\Domain\Payload;

/**
 * Base service
 */
class BaseService
{
    protected function newPayload(string $status, array $result = []): Payload
    {
        return new Payload($status, $result);
    }
}
