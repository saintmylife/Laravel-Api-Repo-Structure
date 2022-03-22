<?php

namespace App\Modules\Auth\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Api\Responder\AuthResponder;
use App\Modules\Auth\Domain\Service\AuthLogout;
use Illuminate\Http\Request;

class AuthLogoutAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(AuthLogout $domain, AuthResponder $responder)
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
