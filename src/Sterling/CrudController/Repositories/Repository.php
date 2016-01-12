<?php

namespace Sterling\CrudController\Repositories;

use Sterling\CrudController\Contracts\Repository as RepositoryInterface;
use Sterling\CrudController\Traits\EloquentRepository;
use Sterling\CrudController\Traits\EloquentSoftDeleteRepository;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface
{
    use EloquentRepository, EloquentSoftDeleteRepository;

    /**
     * @param $model
     *
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }
}