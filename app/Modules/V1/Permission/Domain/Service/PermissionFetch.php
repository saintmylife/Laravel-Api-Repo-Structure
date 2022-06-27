<?php

namespace App\Modules\V1\Permission\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Permission\Repository\PermissionRepository;
use App\Modules\V1\Permission\Resources\PermissionResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermissionFetch extends BaseService
{
    public function __construct(private PermissionRepository $repo)
    {
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = new PermissionResource($this->repo->find($id));
        } catch (ModelNotFoundException) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        if (collect(config('app-config.permissions'))->containsStrict($data->name)) {
            return $this->newPayload(Payload::STATUS_PROTECTED_RESOURCE);
        }
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
