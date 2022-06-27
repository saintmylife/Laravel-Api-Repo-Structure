<?php

namespace App\Modules\V1\User\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\User\Api\Responder\UserResponder;
use App\Modules\V1\User\Domain\Service\UserList;
use Illuminate\Http\Request;

class UserListAction extends Controller
{
    public function __construct(private UserList $domain, private UserResponder $responder)
    {
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
