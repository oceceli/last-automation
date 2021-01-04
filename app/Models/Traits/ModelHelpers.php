<?php

namespace App\Models\Traits;

trait ModelHelpers
{
    // use GlobalHelpers;


    /**
     * Returns current model's url with id.
     */
    public function getPath()
    {
        $path = '/' . strtolower($this->removePath($this->makePlural(static::class))) . '/' . $this->id;
        return url($path);
    }

    public function getEntityType()
    {
        return $this->getTable();
    }

    /**
     * Check if model has the given attribute
     */
    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }



    /**
     * @return bool
     */
    public function checkPivotColumn(string $relationName, $columnName)
    {
        $this->ensureArray($columnName);

        foreach ($columnName as $col) {
            if( ! in_array($col, $this->$relationName()->getPivotColumns()))
                return false;
        }
        return true;
}





    /**********************************************************************
     ******************************* STATICS ******************************
     **********************************************************************/


    public static function getRequestID()
    {
        if (request()->has('id'))
            return request()->get('id');
        return null;
    }

    public static function findAndDelete($id)
    {
        $model = self::find($id);
        return $model->delete();
    }

    
        
}
