<?php

namespace App\Modules\V1\Role\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\Role\Api\Responder\RoleResponder;
use App\Modules\V1\Role\Domain\Service\RoleDelete;

class RoleDeleteAction extends Controller
{
    public function __construct(private RoleDelete $domain, private RoleResponder $responder)
    {
    }

    public function __invoke(int $id)
    {
        $payload = $this->domain->__invoke($id);
        return $this->responder->__invoke($payload);
    }
}
