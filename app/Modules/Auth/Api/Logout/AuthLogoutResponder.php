<?php

namespace App\Modules\Auth\Api\Logout;

use App\Modules\Base\Domain\BaseResponder;

/**
 * AuthLogout responder
 */
class AuthLogoutResponder extends BaseResponder
{
    protected function logout(): void
    {
        $this->renderResult();
    }
}
