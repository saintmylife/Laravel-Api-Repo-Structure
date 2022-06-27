<?php

namespace App\Modules\V1\Test\Api\Action;

use App\Http\Controllers\Controller;
use App\Modules\V1\Test\Api\Responder\TestResponder;
use App\Modules\V1\Test\Domain\Service\TestFetch;

class TestFetchAction extends Controller
{
    public function __construct(private TestFetch $domain, private TestResponder $responder)
    {
    }

    public function __invoke(int $id)
    {
        $payload = $this->domain->__invoke($id);
        return $this->responder->__invoke($payload);
    }
}
