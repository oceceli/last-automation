<?php

namespace App\Http\Controllers\Traits;


trait ControllerHelpers
{

    /**
     * @param App\Model[] $collection Collection instance
     * @param string $parentClass Parent method name of the child class
     * @param string $childClass Children method name of the parent class
     */
    protected function collectionOrderWithChildrenR($collection, $parentClass = 'parent', $childClass = 'children')
    {
        $orderedCollection = [];
        if($collection != null) {
            foreach($collection as $key => $model) {
                if( ! $model->$parentClass()->exists())
                    $orderedCollection[$key] = $this->orderWithChildrenR($model, $childClass);
            }
            return $orderedCollection;
        } else return response("Burada hiçbir şey yok!", 422);
    }


    /**
     * Searches and returns given parent model's children according to given method for children.
     * @param App\Model $parentInstance The parent instance
     * @param String $childClass Children method name of the parent class
     * @return App\Model
     */
    protected function orderWithChildrenR($parentInstance, $childClass = 'children')
    {
        if($parentInstance->$childClass()->exists()) { // verilen parentInstance'ın child'ı varsa
            $children = $parentInstance->$childClass;
            $parentInstance[$childClass] = $children;
            foreach($children as $child) {
                if($child->$childClass()->exists())
                    $this->orderWithChildrenR($child, $childClass);
            }
        }
        return $parentInstance;
    }



    // protected function storeMultiple($datas)
    // {
    //     foreach ($datas as $data) {
    //         $stored[] = $this->repository->store($data);
    //     }
    //     return $stored;
    // }

    // protected function storeSingle($data)
    // {
    //     return $this->repository->store($data);
    // }

    // protected function storeMultipleOrSingle($data)
    // {
    //     return request()->all()['multiple']
    //         ? $this->storeMultiple($data)
    //         : $this->storeSingle($data);
    // }
}
