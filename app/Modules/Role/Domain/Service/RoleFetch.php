<?php

namespace App\Modules\Role\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Role\roleDto;
use App\Modules\Role\Repository\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Role delete
 */
class RoleFetch extends BaseService
{
    private $roleRepo;

    public function __construct(RoleRepositoryInterface $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = $this->roleRepo->with(['permissions'])->find($id);
            return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
    }
}
