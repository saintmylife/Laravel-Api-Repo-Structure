<?php

namespace App\Modules\V1\Auth\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\Auth\Api\Responder\AuthResponder;
use App\Modules\V1\Auth\Domain\Service\AuthRegister;
use Illuminate\Http\Request;

class AuthRegisterAction extends Controller
{
    public function __construct(private AuthRegister $domain, private AuthResponder $responder)
    {
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
