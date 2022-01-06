<?php

namespace App\Modules\Auth\Api\Logout;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Domain\Service\AuthLogout;

/**
 * AuthLogout action
 */
class AuthLogoutAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(AuthLogout $domain, AuthLogoutResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke()
    {
        $payload = $this->domain->__invoke();
        return $this->responder->__invoke($payload);
    }
}
