<?php

namespace Fsociety\Core;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model = null)
    {
        $this->model = $model;
    }

    public function getModel() {
        return $this->model;
    }

    public function setModel(Model $model) {
        $this->model = $model;
    }

    public function getAll() {
        return $this->model->all();
    }

    public function getAllPaginated(int $count) {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->model->paginate($count);
    }

    public function getById(int $id) {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->model->find($id);
    }

    public function getNew($attributes = []) {
        return $this->model->newInstance($attributes);
    }

    public function save($data) {
        if ($data instanceOf Model) {
            return $this->storeEloquentModel($data);
        } elseif(is_array($data)) {
            return $this->storeArray($data);
        }
        return false;
    }

    protected function storeEloquentModel(Model $model) {
        if($model->getDirty()) {
            return $model->save();
        }
        return $model->touch();
    }

    protected function storeArray(array $data) {
        $model = $this->getNew($data);
        return $this->storeEloquentModel($model);
    }

}