<?php

namespace App\Http\Controllers\Traits;

// use App\Traits\GlobalHelpers;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

/**
 * Basically checks whether resource exists or not
 * And returning the data within or without resource
 *
 * Resource path must be \App\Http\Resources\ and the class name must be like 'User'
 */
trait Resources
{
    // use GlobalHelpers;

    protected function decideResource($data, $resourceClass = null)
    {
        if($resourceClass !== null)
            $resourceClass = Str::singular($resourceClass);

        $data instanceof Collection
            ? $resource = $this->ResourcePath($resourceClass, true)
            : $resource = $this->ResourcePath($resourceClass);
        return new $resource($data);
    }

    /**
     * If resource name provided, return resource path relative to given resourceModel
     * Else return current class' resource path
     */
    private function ResourcePath($resourceClass = null, bool $isCollection = false)
    {
        $resourceClass !== null
            ? $path = '\App\Http\Resources\\' . ucfirst($resourceClass)
            : $path =  '\App\Http\Resources\\' . ucfirst($this->getClassName());
        if($isCollection) $path = $path . 'Collection';

        if( ! class_exists($path)) throw new Exception('Resource class "' . $path . '" bulunamadı!');
        return $path;
    }

    // getModelPath DefaultController'e bağlı. Ona çözüm bulurum sonra
    /**
     * @return string
     */
    private function getClassName()
    {
        return $this->removePath($this->getModelPath());
    }



}
