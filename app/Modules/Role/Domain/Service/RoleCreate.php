<?php

namespace App\Modules\Role\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Role\Domain\RoleFilter;
use App\Modules\Role\Repository\RoleRepositoryInterface;
use App\Modules\Role\RoleDto;
use Illuminate\Support\Facades\Hash;

/**
 * RoleCreate domain
 */
class RoleCreate extends BaseService
{
    private $filter;
    private $roleRepo;

    public function __construct(RoleFilter $filter, RoleRepositoryInterface $roleRepo)
    {
        $this->filter = $filter;
        $this->roleRepo = $roleRepo;
    }

    public function __invoke(array $data): Payload
    {
        $roleDto = $this->makeDto($data, new RoleDto);

        if (! $this->filter->forInsert($roleDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        $create = $this->roleRepo->create([
            'name'          => $roleDto->getData()['name'],
            'guard_name'    => 'api'
        ]);

        $create->syncPermissions($roleDto->permissions);

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
