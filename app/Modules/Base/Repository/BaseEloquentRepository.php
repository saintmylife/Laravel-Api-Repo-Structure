<?php

namespace App\Modules\Base\Repository;

use Prettus\Repository\Eloquent\BaseRepository;

abstract class BaseEloquentRepository extends BaseRepository
{
    public function findTrashedById(int $id)
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->onlyTrashed()->where('id', $id)->firstOrFail();
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function forceDelete($id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $deleted = $this->model->withTrashed()->find($id)->forceDelete();

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        return $deleted;
    }

    public function restoreTrashedById(int $id)
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->findTrashedById($id)->restore();
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function findSlug(string $slug)
    {
        return $this->findWhere(['slug' => $slug])->firstOrFail();
    }
}
