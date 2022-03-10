<?php

namespace App\Modules\Permission\Repository;

use Spatie\Permission\Models\Permission;
use App\Modules\Base\Repository\BaseEloquentRepository;

/**
 * PermissionRepository Eloquent
 */
class PermissionRepositoryEloquent extends BaseEloquentRepository implements PermissionRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }
}
