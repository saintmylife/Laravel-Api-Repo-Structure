<?php

namespace App\Modules\V1\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\User\Repository\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRestore extends BaseService
{
    public function __construct(private UserRepository $repo)
    {
    }

    public function __invoke(int $id): Payload
    {
        try {
            $update = $this->repo->restoreTrashedById($id);
        } catch (ModelNotFoundException) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
