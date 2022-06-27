<?php

namespace App\Modules\V1\Role\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class RoleRepositoryEloquent extends BaseEloquentRepository implements RoleRepository
{
    protected $fieldSearchable = ['name' => 'like'];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return config('permission.models.role');
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
