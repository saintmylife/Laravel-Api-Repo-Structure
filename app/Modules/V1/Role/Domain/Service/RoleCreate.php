<?php

namespace App\Modules\V1\Role\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Role\Domain\RoleFilter;
use App\Modules\V1\Role\Repository\RoleRepository;
use App\Modules\V1\Role\Resources\RoleResource;
use App\Modules\V1\Role\RoleDto;

class RoleCreate extends BaseService
{
    public function __construct(private RoleFilter $filter, private RoleRepository $repo)
    {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forInsert($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $roleDto = new RoleDto($this->filter->getValidatedData());

        $create = new RoleResource($this->repo->create($roleDto->getData()));

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
