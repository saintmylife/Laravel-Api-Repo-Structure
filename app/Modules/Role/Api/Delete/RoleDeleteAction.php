<?php

namespace App\Modules\Role\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\Role\Domain\Service\RoleDelete;

/**
 * RoleDelete action
 */
class RoleDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(RoleDelete $domain, RoleDeleteResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(int $id)
    {
        $payload = $this->domain->__invoke($id);
        return $this->responder->__invoke($payload);
    }
}
