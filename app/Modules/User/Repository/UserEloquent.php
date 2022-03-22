<?php

namespace App\Modules\User\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use App\Models\User;

class UserEloquent extends BaseEloquentRepository implements UserRepoInterface
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
        return User::class;
    }
    /*
    |--------------------------------------------------------------------------
    | Define function helper
    |--------------------------------------------------------------------------
    * @return mixed
    */
}
