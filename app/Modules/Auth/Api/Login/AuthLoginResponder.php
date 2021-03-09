<?php

namespace App\Modules\Auth\Api\Login;

use App\Modules\Base\Domain\BaseResponder;

/**
 * AuthLogin responder
 */
class AuthLoginResponder extends BaseResponder
{
    public function authenticated(): void
    {
        $this->renderResult();
    }

    public function authFailed(): void
    {
        $this->response = response()->json($this->payload->getResult(), 401);
    }
}
