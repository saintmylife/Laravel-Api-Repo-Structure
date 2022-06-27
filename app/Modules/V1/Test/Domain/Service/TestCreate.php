<?php

namespace App\Modules\V1\Test\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Test\Domain\TestFilter;
use App\Modules\V1\Test\Repository\TestRepository;
use App\Modules\V1\Test\TestDto;

class TestCreate extends BaseService
{
    public function __construct(private TestFilter $filter, private TestRepository $repo)
    {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forInsert($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $testDto = new TestDto($this->filter->getValidatedData());

        $create = $this->repo->create($testDto->getData());

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
