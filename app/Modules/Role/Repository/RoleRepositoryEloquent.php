<?php

namespace App\Modules\Role\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use Spatie\Permission\Models\Role;

/**
 * RoleRepository Eloquent
 */
class RoleRepositoryEloquent extends BaseEloquentRepository implements RoleRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }
}
