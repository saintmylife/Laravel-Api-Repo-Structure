<?php

namespace App\Modules\V1\Test\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Test\Repository\TestRepository;

class TestDelete extends BaseService
{
    public function __construct(private TestFetch $fetch, private TestRepository $repo)
    {
    }

    public function __invoke(int $id): Payload
    {
        if(($test = $this->fetch->__invoke($id))->getStatus() != 'FOUND'){
            return $test;
        }
        $this->repo->delete($id);
        $messages = 'test deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('messages'));
    }
}
