<?php

namespace App\Modules\Role\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Role\Repository\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Role delete
 */
class RoleDelete extends BaseService
{
    private $roleRepo;

    public function __construct(RoleRepositoryInterface $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    public function __invoke(int $id): Payload
    {
        try {
            $this->roleRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }

        $this->roleRepo->delete($id);
        $message = 'Role deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
