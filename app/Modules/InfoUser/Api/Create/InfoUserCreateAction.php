<?php

namespace App\Modules\InfoUser\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\InfoUser\Domain\Service\InfoUserCreate;
use Illuminate\Http\Request;

/**
 * UserCreate action
 */
class InfoUserCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(InfoUserCreate $domain, InfoUserCreateResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
