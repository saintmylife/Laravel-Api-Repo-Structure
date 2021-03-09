<?php

namespace App\Modules\Role\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\Role\Domain\Service\RoleEdit;
use Illuminate\Http\Request;

/**
 * RoleEdit action
 */
class RoleEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(RoleEdit $domain, RoleEditResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request, int $id)
    {
        $payload = $this->domain->__invoke($id, $request->all());
        return $this->responder->__invoke($payload);
    }
}
