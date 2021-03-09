<?php

namespace App\Modules\InfoUser\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\InfoUser\Domain\Service\InfoUserFetch;
use Illuminate\Http\Request;

/**
 * InfoUserFetch action
 */
class InfoUserFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(InfoUserFetch $domain, InfoUserFetchResponder $responder)
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
