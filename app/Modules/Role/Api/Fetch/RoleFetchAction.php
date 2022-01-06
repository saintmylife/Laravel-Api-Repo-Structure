<?php

namespace App\Modules\Role\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\Role\Domain\Service\RoleFetch;
use Illuminate\Http\Request;

/**
 * RoleFetch action
 */
class RoleFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(RoleFetch $domain, RoleFetchResponder $responder)
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
