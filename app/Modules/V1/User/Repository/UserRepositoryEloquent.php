<?php

namespace App\Modules\V1\User\Repository;

use App\Exceptions\BannedUserException;
use App\Models\User;
use App\Modules\Base\Repository\BaseEloquentRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class UserRepositoryEloquent extends BaseEloquentRepository implements UserRepository
{
    protected $fieldSearchable = [
        'email' => 'like',
        'username' => 'like',
        'name' => 'like',
        'address' => 'like',
        'phone' => 'like',
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
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

    public function findEmailOrUsername(string $email)
    {
        $model =  $this->model->where('email', $email)->orWhere('username', $email)->firstOrFail();
        $this->resetModel();
        return $this->parserResult($model);
    }
    public function restoreTrashedById(int $id)
    {
        $this->applyCriteria();
        $this->applyScope();
        $this->findTrashedById($id)->restore();
        $this->resetModel();
        $model = $this->update([
            'deleted_reason' => null
        ], $id);

        return $this->parserResult($model);
    }
    public function findForUser(string $credential)
    {
        $model = $this->model->withTrashed()->where('email', $credential)->orWhere('username', $credential)->firstOrFail();
        $this->resetModel();
        if (!empty($model->deleted_at)) {
            throw new BannedUserException($model->deleted_reason);
        }
        return $this->parserResult($model);
    }
}
