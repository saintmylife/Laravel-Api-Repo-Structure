<?php

namespace App\Modules\Role\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Role\Repository\RoleRepositoryInterface;

/**
 * Role list
 */
class RoleList extends BaseService
{
    private $roleRepo;

    public function __construct(RoleRepositoryInterface $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    public function __invoke($request)
    {
        $data = $this->roleRepo->paginate(isset($request['per_page']) ? $request['per_page'] : 100);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
