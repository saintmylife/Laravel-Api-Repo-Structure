<?php

namespace App\Modules\Role\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Role\Domain\RoleFilter;
use App\Modules\Role\Repository\RoleRepositoryInterface;
use App\Modules\Role\RoleDto;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * RoleEdit service
 */
class RoleEdit extends BaseService
{
    private $filter;
    private $roleRepo;

    public function __construct(RoleFilter $filter, RoleRepositoryInterface $roleRepo)
    {
        $this->filter = $filter;
        $this->roleRepo = $roleRepo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $roleDto = $this->makeDto($data, new RoleDto);
        $roleDto->id = $id;
        if (! $this->filter->forUpdate($roleDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        try {
            $this->roleRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }

        $update = $this->roleRepo->update([
            'name'          => $roleDto->getData()['name'],
            'guard_name'    => 'api'
        ], $id);

        $update->syncPermissions($roleDto->permissions);

        return $this->newPayload(Payload::STATUS_UPDATED, compact('data'));
    }
}
