<?php

namespace App\Modules\Auth\Api\Profile;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Domain\Service\AuthProfile;

/**
 * AuthProfile action
 */
class AuthProfileAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(AuthProfile $domain, AuthProfileResponder $responder)
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
