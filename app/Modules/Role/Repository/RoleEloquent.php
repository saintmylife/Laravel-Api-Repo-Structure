<?php

namespace App\Modules\Role\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use Spatie\Permission\Models\Role;

class RoleEloquent extends BaseEloquentRepository implements RoleRepoInterface
{

    protected $fieldSearchable = [];

    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }
    /*
    |--------------------------------------------------------------------------
    | Define function helper
    |--------------------------------------------------------------------------
    * @return mixed
    */
}
