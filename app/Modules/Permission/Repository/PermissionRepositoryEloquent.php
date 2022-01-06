<?php

namespace App\Modules\Permission\Repository;

use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\Permission\Models\Permission;

/**
 * PermissionRepository Eloquent
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepositoryInterface
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
