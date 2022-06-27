<?php

namespace App\Modules\V1\User\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\User\Api\Responder\UserResponder;
use App\Modules\V1\User\Domain\Service\UserChangeRole;
use Illuminate\Http\Request;

class UserChangeRoleAction extends Controller
{
    public function __construct(private UserChangeRole $domain, private UserResponder $responder)
    {
    }

    public function __invoke(Request $request, int $id)
    {
        $payload = $this->domain->__invoke($id, $request->all());
        return $this->responder->__invoke($payload);
    }
}
