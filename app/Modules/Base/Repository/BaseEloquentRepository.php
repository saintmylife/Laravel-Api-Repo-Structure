<?php

namespace App\Modules\Base\Repository;

use Prettus\Repository\Eloquent\BaseRepository;

abstract class BaseEloquentRepository extends BaseRepository
{
    public function findTrashedById($id)
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->onlyTrashed()->where('id', $id)->firstOrFail();
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function restoreTrashedById($id)
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->findTrashedById($id)->restore();
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function forceDeleteById($id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = $this->findTrashedById($id);

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        $deleted = $model->forceDelete();

        return $deleted;
    }

    public function findSlug(string $slug)
    {
        return $this->findWhere(['slug' => $slug])->firstOrFail();
    }
}
