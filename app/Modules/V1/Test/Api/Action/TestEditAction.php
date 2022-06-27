<?php

namespace App\Modules\V1\Test\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\Test\Api\Responder\TestResponder;
use App\Modules\V1\Test\Domain\Service\TestEdit;
use Illuminate\Http\Request;

class TestEditAction extends Controller
{
    public function __construct(private TestEdit $domain, private TestResponder $responder)
    {
    }

    public function __invoke(Request $request,int $id)
    {
        $payload = $this->domain->__invoke($id, $request->all());
        return $this->responder->__invoke($payload);
    }
}
