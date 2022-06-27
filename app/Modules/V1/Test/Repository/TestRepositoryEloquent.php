<?php

namespace App\Modules\V1\Test\Repository;

use App\Models\Test;
use App\Modules\Base\Repository\BaseEloquentRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class TestRepositoryEloquent extends BaseEloquentRepository implements TestRepository
{
    protected $fieldSearchable = [];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Test::class;
    }
    
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /*
    |--------------------------------------------------------------------------
    | Define function helper
    |--------------------------------------------------------------------------
    * @return mixed
    */
}
