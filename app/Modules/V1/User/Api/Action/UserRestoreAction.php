<?php

namespace App\Modules\V1\User\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\User\Api\Responder\UserResponder;
use App\Modules\V1\User\Domain\Service\UserRestore;

class UserRestoreAction extends Controller
{
    public function __construct(private UserRestore $domain, private UserResponder $responder)
    {
    }

    public function __invoke(int $id)
    {
        $payload = $this->domain->__invoke($id);
        return $this->responder->__invoke($payload);
    }
}
