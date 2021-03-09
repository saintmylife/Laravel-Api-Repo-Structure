<?php

namespace App\Modules\Auth\Api\Login;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Domain\Service\AuthLogin;
use Illuminate\Http\Request;

/**
 * AuthLogin action
 */
class AuthLoginAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(AuthLogin $domain, AuthLoginResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
