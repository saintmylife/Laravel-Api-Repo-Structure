<?php

namespace App\Modules\V1\Permission\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\Permission\Api\Responder\PermissionResponder;
use App\Modules\V1\Permission\Domain\Service\PermissionFetch;

class PermissionFetchAction extends Controller
{
    public function __construct(private PermissionFetch $domain, private PermissionResponder $responder)
    {
    }

    public function __invoke(int $id)
    {
        $payload = $this->domain->__invoke($id);
        return $this->responder->__invoke($payload);
    }
}
