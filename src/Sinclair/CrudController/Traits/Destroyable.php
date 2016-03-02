<?php

namespace Sinclair\CrudController\Traits;

trait Destroyable
{

    /**
     * Remove the specified resource from storage.
     *
     *
     * @param $model
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($model)
    {
        try{
            $this->repository->destroy($model);
            $success = true;
        }catch(\Exception $e){
            $success = false;
        }

        return $this->crudResponse($success);
    }

}