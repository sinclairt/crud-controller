<?php

namespace Sterling\CrudController\Traits;

use Sterling\CrudController\Responses\SterlingResponse;
use Request;
use Illuminate\Database\Eloquent\Model;

trait ControllerResponses
{

    /**
     * Store a newly created resource in storage.
     * write the store() method in your own class and inject the proper request object
     *
     * usage:
     *
     * store(MyRequest $request){
     *  return $this->doStore($request);
     * }
     *
     * @param param Request $createRequest
     * @param string $route
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function doStore($createRequest, $route = null)
    {
        return $this->crudResponse($this->repository->add($createRequest->all()), $route);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param param Request $updateRequest
     * @param Model $model
     *
     * @param string $route
     *
     * @return mixed
     */
    protected function doUpdate($updateRequest, Model $model, $route = null)
    {
        try
        {
            $result = true;

            $this->repository->update($updateRequest->all(), $model);
        }
        catch (\Exception $e)
        {
            $result = false;
        }

        return $this->crudResponse($result, $route);
    }

    /**
     * respond to a crud add/update
     *
     * @param $resultOfRepositoryAction
     * @param string $route
     *
     * @param $routeParams
     * @param null $message
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function crudResponse($resultOfRepositoryAction, $route = null, $routeParams = null, $message = null)
    {
        return $this->isAjax() ?
            $resultOfRepositoryAction ?
                SterlingResponse::jsonSuccess($this->successMessage($message)) :
                SterlingResponse::jsonFailure($this->failureMessage($message)) :
            $this->redirectToRoute($route, $routeParams, $message);
    }

    protected function redirectToRoute($route, $routeParams, $message)
    {
        return redirect()
            ->route($this->getRoute($route), $routeParams)
            ->with('message', $message);
    }

    /**
     * @return string
     */
    public function getRouteName()
    {
        if ($this->prefix != null)
            return $this->prefix . '.' . $this->class;

        return $this->class;
    }

    /**
     * @param $route
     *
     * @return string
     */
    protected function getRoute($route)
    {
        return $route == null ? $this->getRouteName() . '.index' : $route;
    }

    /**
     * @param $message
     * @param $default
     *
     * @return mixed
     */
    protected function setMessage(&$message, $default)
    {
        return $message == null ? $default : $message;
    }

    /**
     * @return bool
     */
    protected function isAjax()
    {
        return Request::ajax() || Request::wantsJson();
    }

    /**
     * @param $message
     *
     * @return array
     */
    protected function successMessage(&$message)
    {
        $message = $this->setMessage($message, 'Your request was processed successfully.');

        return compact('message');
    }

    /**
     * @param $message
     *
     * @return array
     */
    protected function failureMessage(&$message)
    {
        $message = $this->setMessage($message, 'Your request failed to process, please try again.');

        return compact('message');
    }
}