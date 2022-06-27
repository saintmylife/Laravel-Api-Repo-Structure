<?php

namespace App\Modules\V1\Test\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Test\Repository\TestRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TestFetch extends BaseService
{
    public function __construct(private TestRepository $repo)
    {
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = $this->repo->find($id);
        } catch (ModelNotFoundException) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
