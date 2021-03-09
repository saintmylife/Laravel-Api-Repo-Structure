<?php

namespace App\Modules\InfoUser\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\InfoUser\Domain\Service\InfoUserEdit;
use Illuminate\Http\Request;

/**
 * InfoUserEdit action
 */
class InfoUserEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(InfoUserEdit $domain, InfoUserEditResponder $responder)
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
