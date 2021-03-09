<?php

namespace App\Modules\Permission\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\Permission\Domain\Service\PermissionList;
use Illuminate\Http\Request;

/**
 * PermissionIndex action
 */
class PermissionIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(PermissionList $domain, PermissionIndexResponder $responder)
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
