<?php

namespace App\Modules\V1\Test\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Test\Domain\TestFilter;
use App\Modules\V1\Test\Repository\TestRepository;
use App\Modules\V1\Test\TestDto;

class TestEdit extends BaseService
{
    public function __construct(private TestFetch $fetch,private TestFilter $filter, private TestRepository $repo)
    {
    }

    public function __invoke(int $id, array $data): Payload
    {
        if(($test = $this->fetch->__invoke($id))->getStatus() != 'FOUND'){
            return $test;
        }
        $test = $test->getResult()['data'];

        if (!$this->filter->forUpdate($data,$id)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }
        $testDto = new TestDto($this->filter->getValidatedData());
        $testDto->id = $id;

        $update = $this->repo->update($testDto->getData(), $id);
        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
