<?php

namespace App\Modules\V1\Permission\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Permission\Domain\PermissionFilter;
use App\Modules\V1\Permission\PermissionDto;
use App\Modules\V1\Permission\Repository\PermissionRepository;

class PermissionEdit extends BaseService
{
    public function __construct(private PermissionFetch $fetch, private PermissionFilter $filter, private PermissionRepository $repo)
    {
    }

    public function __invoke(int $id, array $data): Payload
    {
        if (($permission = $this->fetch->__invoke($id))->getStatus() != 'FOUND') {
            return $permission;
        }

        if (!$this->filter->forUpdate($data, $id)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }
        $permissionDto = new PermissionDto($this->filter->getValidatedData());

        $update = $this->repo->update($permissionDto->getData(), $id);
        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
