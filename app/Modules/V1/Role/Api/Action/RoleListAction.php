<?php

namespace App\Modules\V1\Role\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\Role\Api\Responder\RoleResponder;
use App\Modules\V1\Role\Domain\Service\RoleList;
use Illuminate\Http\Request;

class RoleListAction extends Controller
{
    public function __construct(private RoleList $domain, private RoleResponder $responder)
    {
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
