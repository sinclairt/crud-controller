<?php

namespace Sterling\CrudController\Traits;

use Sterling\Repository\Contracts\Repository;
use Sterling\MagicViews\HasMagicViews;
use Illuminate\Database\Eloquent\Model;
use Sterling\Responses\ControllerResponses;

trait CrudController
{
    use ControllerResponses, Destroyable, HasMagicViews;

    /**
     * @var
     */
    protected $class;

    /**
     * @var null
     */
    protected $prefix = null;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @param Repository $repository
     */
    public function setUp(Repository $repository)
    {
        // this will set the class name automatically, even for a child of this class
        // as long as this constructor is called using parent::__construct();
        $this->class = $this->getClassName(get_class($this));

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = $this->repository->getAllPaginate();

        return $this->indexView(get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->createView();
    }

    /**
     * @param \Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(\Request $request)
    {
        return $this->doStore($request);
    }

    /**
     * Display the specified resource.
     *
     *
     * @param $model
     *
     * @return \Illuminate\Http\Response
     */
    public function show($model)
    {
        return $this->showView(get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $model
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($model)
    {
        return $this->editView(get_defined_vars());
    }

    /**
     * @param \Request $request
     * @param Model $model
     *
     * @return mixed
     */
    public function update(\Request $request, $model)
    {
        return $this->doUpdate($request, $model);
    }

    /**
     * Restore the specified resource from storage
     *
     * @param $model
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($model)
    {
        return $this->crudResponse($this->repository->restore($model));
    }


    /**
     * @param $classPath
     *
     * @return mixed
     */
    protected function getClassName($classPath)
    {
        return snake_case(str_replace('Controller','',class_basename($classPath)));
    }



}