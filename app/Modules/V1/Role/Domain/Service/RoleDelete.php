<?php

namespace App\Modules\V1\Role\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Role\Repository\RoleRepository;

class RoleDelete extends BaseService
{
    public function __construct(private RoleFetch $fetch, private RoleRepository $repo)
    {
    }

    public function __invoke(int $id): Payload
    {
        if (($role = $this->fetch->__invoke($id))->getStatus() != 'FOUND') {
            return $role;
        }
        $this->repo->delete($id);
        $messages = 'role deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('messages'));
    }
}
