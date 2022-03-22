<?php

namespace App\Modules\Permission\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use Spatie\Permission\Models\Permission;

class PermissionEloquent extends BaseEloquentRepository implements PermissionRepoInterface
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
        return Permission::class;
    }
    /*
    |--------------------------------------------------------------------------
    | Define function helper
    |--------------------------------------------------------------------------
    * @return mixed
    */
}
