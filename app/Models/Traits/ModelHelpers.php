<?php

namespace App\Models\Traits;

use App\Common\Helpers\Generic;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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


    
    /**
     * Get current table's column names except _id's and timestamps
     */
    public static function columnsToBeSearched()
    {
        if(method_exists(self::class, 'searchStrings')) return self::searchStrings();

        $array = Schema::getColumnListing(Str::plural(Generic::toSnakeCase(self::class)));
        $idsAppended = [];

        // find '_id' appended attributes. Will be extracted from search index
        foreach($array as $item) {
            if(Generic::detectIdAppending($item)) $idsAppended[] = $item;
        }

        // extract unnecessary attributes from index
        return array_values(array_diff($array, array_merge(['id', 'created_at', 'updated_at'], $idsAppended)));

    }

    
        
}
