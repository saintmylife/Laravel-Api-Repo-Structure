<?php

namespace App\Modules\V1\Test\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Test\Repository\TestRepository;

class TestList extends BaseService
{
    public function __construct(private TestRepository $repo)
    {
    }

    public function __invoke($request)
    {
        $data = $this->repo->paginate(isset($request['per_page']) ?? null)->onEachSide(0);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
