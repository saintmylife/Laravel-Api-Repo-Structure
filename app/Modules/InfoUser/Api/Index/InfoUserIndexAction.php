<?php

namespace App\Modules\InfoUser\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\InfoUser\Domain\Service\InfoUserList;
use Illuminate\Http\Request;


/**
 * InfoUserIndex action
 */
class InfoUserIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(InfoUserList $domain, InfoUserIndexResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }


    function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
