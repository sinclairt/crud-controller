<?php

namespace Sinclair\CrudController\Traits;

use Illuminate\Http\Request;
use Sinclair\Repository\Contracts\Repository;
use Sinclair\MagicViews\HasMagicViews;
use Illuminate\Database\Eloquent\Model;
use Sinclair\Responses\ControllerResponses;

/**
 * Class CrudController
 * @package Sinclair\CrudController\Traits
 */
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
    public function setUp( Repository $repository )
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
        if ( method_exists($this, 'formData') )
            extract($this->formData());

        return $this->createView(get_defined_vars());
    }

    /**
     * @param \Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( \Request $request )
    {
        return $this->doStore($request, null, null, $this->guessMessage());
    }

    /**
     * Display the specified resource.
     *
     *
     * @param $model
     *
     * @return \Illuminate\Http\Response
     */
    public function show( $model )
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
    public function edit( $model )
    {
        if ( method_exists($this, 'formData') )
            extract($this->formData($model));

        return $this->editView(get_defined_vars());
    }

    /**
     * @param \Request $request
     * @param Model $model
     *
     * @return mixed
     */
    public function update( \Request $request, $model )
    {
        return $this->doUpdate($request, $model, null, null, $this->guessMessage());
    }

    /**
     * Restore the specified resource from storage
     *
     * @param $model
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore( $model )
    {
        return $this->crudResponse($this->repository->restore($model), null, null, $this->guessMessage());
    }

    /**
     * @param $classPath
     *
     * @return mixed
     */
    protected function getClassName( $classPath )
    {
        return snake_case(str_replace('Controller', '', class_basename($classPath)));
    }

    /**
     * @return mixed
     */
    protected function getResourceNameProperCase()
    {
        return ucwords(str_replace('_', ' ', $this->class));
    }

    /**
     * @param $verb
     *
     * @return string
     */
    protected function guessMessage( $verb = null )
    {
        $verb = is_null($verb) ? array_get(debug_backtrace(), '1.function') : $verb;

        $verb .= ends_with($verb, 'e') ? 'd' : 'ed';

        if ( $class = trans('crud-controller::resources.' . $this->class) == 'crud-controller::resources.' . $this->class )
            $class = $this->getResourceNameProperCase();

        return $class . ' ' . $verb . '!';
    }

    /**
     * @return null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param null $prefix
     *
     * @return $this
     */
    public function setPrefix( $prefix )
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @param string $resource
     *
     * @return string
     */
    public function route( $resource = 'index' )
    {
        return implode('.', array_filter([ $this->getPrefix(), $this->class, $resource ]));
    }
}