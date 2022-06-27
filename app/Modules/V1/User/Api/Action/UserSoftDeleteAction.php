<?php

namespace App\Modules\V1\User\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\User\Api\Responder\UserResponder;
use App\Modules\V1\User\Domain\Service\UserSoftDelete;
use Illuminate\Http\Request;

class UserSoftDeleteAction extends Controller
{
    public function __construct(private UserSoftDelete $domain, private UserResponder $responder)
    {
    }

    public function __invoke(Request $request, int $id)
    {
        $payload = $this->domain->__invoke($id, $request->all());
        return $this->responder->__invoke($payload);
    }
}
