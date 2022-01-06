<?php

namespace App\Modules\Permission\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Permission\Repository\PermissionRepositoryInterface;
use Auth;

/**
 * Permission list
 */
class PermissionList extends BaseService
{
    private $permissionRepo;

    public function __construct(PermissionRepositoryInterface $permissionRepo)
    {
        $this->permissionRepo = $permissionRepo;
    }

    public function __invoke($request)
    {
        $data = $this->permissionRepo->paginate(isset($request['per_page']) ? $request['per_page'] : 100);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
