<?php

namespace App\Modules\Auth\Repository;

use App\Models\Auth;
use App\Modules\Base\Repository\BaseEloquentRepository;

class AuthEloquent extends BaseEloquentRepository implements AuthRepoInterface
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
        return Auth::class;
    }
    /*
    |--------------------------------------------------------------------------
    | Define function helper
    |--------------------------------------------------------------------------
    * @return mixed
    */
}
