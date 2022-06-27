<?php

namespace App\Modules\V1\Permission\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\Permission\Api\Responder\PermissionResponder;
use App\Modules\V1\Permission\Domain\Service\PermissionList;
use Illuminate\Http\Request;

class PermissionListAction extends Controller
{
    public function __construct(private PermissionList $domain, private PermissionResponder $responder)
    {
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
