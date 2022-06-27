<?php

namespace App\Modules\V1\Test\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\Test\Api\Responder\TestResponder;
use App\Modules\V1\Test\Domain\Service\TestList;
use Illuminate\Http\Request;

class TestListAction extends Controller
{
    public function __construct(private TestList $domain, private TestResponder $responder)
    {
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
