<?php

namespace App\Modules\InfoUser\Repository;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * UserRepository Eloquent
 */
class InfoUserRepositoryEloquent extends BaseRepository implements InfoUserRepositoryInterface
{

    protected $fieldSearchable = [
        'name' => 'like',
    ];

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
        return InfoUser::class;
    }
}
