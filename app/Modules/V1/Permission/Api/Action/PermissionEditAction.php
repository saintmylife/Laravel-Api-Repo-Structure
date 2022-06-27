<?php

namespace App\Modules\V1\Permission\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\Permission\Api\Responder\PermissionResponder;
use App\Modules\V1\Permission\Domain\Service\PermissionEdit;
use Illuminate\Http\Request;

class PermissionEditAction extends Controller
{
    public function __construct(private PermissionEdit $domain, private PermissionResponder $responder)
    {
    }

    public function __invoke(Request $request, int $id)
    {
        $payload = $this->domain->__invoke($id, $request->all());
        return $this->responder->__invoke($payload);
    }
}
