<?php

namespace App\Modules\V1\Permission\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class PermissionRepositoryEloquent extends BaseEloquentRepository implements PermissionRepository
{
    protected $fieldSearchable = [];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return config('permission.models.permission');
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
