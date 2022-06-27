<?php

namespace App\Modules\V1\Role\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Role\Domain\RoleFilter;
use App\Modules\V1\Role\Repository\RoleRepository;
use App\Modules\V1\Role\Resources\RoleResource;
use App\Modules\V1\Role\RoleDto;

class RoleEdit extends BaseService
{
    public function __construct(private RoleFetch $fetch, private RoleFilter $filter, private RoleRepository $repo)
    {
    }

    public function __invoke(int $id, array $data): Payload
    {
        if (($role = $this->fetch->__invoke($id))->getStatus() != 'FOUND') {
            return $role;
        }

        if (!$this->filter->forUpdate($data, $id)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }
        $roleDto = new RoleDto($this->filter->getValidatedData());

        $update = new RoleResource($this->repo->update($roleDto->getData(), $id));
        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
