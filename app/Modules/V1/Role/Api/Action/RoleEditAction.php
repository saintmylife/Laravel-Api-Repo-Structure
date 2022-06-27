<?php

namespace App\Modules\V1\Role\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\Role\Api\Responder\RoleResponder;
use App\Modules\V1\Role\Domain\Service\RoleEdit;
use Illuminate\Http\Request;

class RoleEditAction extends Controller
{
    public function __construct(private RoleEdit $domain, private RoleResponder $responder)
    {
    }

    public function __invoke(Request $request, int $id)
    {
        $payload = $this->domain->__invoke($id, $request->all());
        return $this->responder->__invoke($payload);
    }
}
