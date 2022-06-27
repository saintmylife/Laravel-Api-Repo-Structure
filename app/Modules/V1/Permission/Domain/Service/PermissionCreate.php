<?php

namespace App\Modules\V1\Permission\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Permission\Domain\PermissionFilter;
use App\Modules\V1\Permission\PermissionDto;
use App\Modules\V1\Permission\Repository\PermissionRepository;
use App\Modules\V1\Permission\Resources\PermissionResource;

class PermissionCreate extends BaseService
{
    public function __construct(private PermissionFilter $filter, private PermissionRepository $repo)
    {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forInsert($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $permissionDto = new PermissionDto($this->filter->getValidatedData());

        $create = new PermissionResource($this->repo->create($permissionDto->getData()));

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
