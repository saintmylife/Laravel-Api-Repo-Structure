<?php

namespace App\Modules\V1\Permission\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Permission\Repository\PermissionRepository;

class PermissionDelete extends BaseService
{
    public function __construct(private PermissionFetch $fetch, private PermissionRepository $repo)
    {
    }

    public function __invoke(int $id): Payload
    {
        if (($permission = $this->fetch->__invoke($id))->getStatus() != 'FOUND') {
            return $permission;
        }
        $this->repo->delete($id);
        $messages = 'permission deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('messages'));
    }
}
