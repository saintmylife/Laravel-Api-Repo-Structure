<?php

namespace App\Modules\Role\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\Role\Domain\Service\RoleList;
use Illuminate\Http\Request;

/**
 * RoleIndex action
 */
class RoleIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(RoleList $domain, RoleIndexResponder $responder)
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
