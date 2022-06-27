<?php

namespace App\Modules\V1\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\User\Repository\UserRepository;
use App\Modules\V1\User\Resources\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserFetch extends BaseService
{
    public function __construct(private UserRepository $repo)
    {
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = new UserResource($this->repo->find($id));
        } catch (ModelNotFoundException) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
