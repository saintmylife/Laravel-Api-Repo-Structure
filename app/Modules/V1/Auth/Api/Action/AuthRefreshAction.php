<?php

namespace App\Modules\V1\Auth\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\Auth\Api\Responder\AuthResponder;
use App\Modules\V1\Auth\Domain\Service\AuthRefresh;

class AuthRefreshAction extends Controller
{
    public function __construct(private AuthRefresh $domain, private AuthResponder $responder)
    {
    }

    public function __invoke()
    {
        $payload = $this->domain->__invoke();
        return $this->responder->__invoke($payload);
    }
}
