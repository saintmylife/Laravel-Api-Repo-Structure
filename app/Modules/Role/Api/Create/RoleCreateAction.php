<?php

namespace App\Modules\Role\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\Role\Domain\Service\RoleCreate;
use Illuminate\Http\Request;

/**
 * RoleCreate action
 */
class RoleCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(RoleCreate $domain, RoleCreateResponder $responder)
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
