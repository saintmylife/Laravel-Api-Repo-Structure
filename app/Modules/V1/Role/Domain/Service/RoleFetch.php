<?php

namespace App\Modules\V1\Role\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Role\Repository\RoleRepository;
use App\Modules\V1\Role\Resources\RoleResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleFetch extends BaseService
{
    public function __construct(private RoleRepository $repo)
    {
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = new RoleResource($this->repo->find($id));
        } catch (ModelNotFoundException) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        if (collect(config('app-config.roles'))->containsStrict($data->name)) {
            return $this->newPayload(Payload::STATUS_PROTECTED_RESOURCE);
        }
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
