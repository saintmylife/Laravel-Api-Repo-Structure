<?php

namespace App\Modules\Role\Repository;

use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\Permission\Models\Role;

/**
 * RoleRepository Eloquent
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepositoryInterface
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
