<?php

namespace App\Modules\V1\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\User\Repository\UserRepository;

class UserList extends BaseService
{
    public function __construct(private UserRepository $repo)
    {
    }

    public function __invoke($request): Payload
    {
        $data = $this->repo->paginate($request['per_page'] ?? null)->onEachSide(0);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
