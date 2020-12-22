<?php

namespace App\Models\Traits;

// use App\Traits\GlobalHelpers;

use App\Common\Helpers\Generic;
use Illuminate\Database\Eloquent\Builder;
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
        $model->delete();
    }

    /**
     * Get current table's column names.
     */
    // public static function getColumnNames()
    // {
    //     return Schema::getColumnListing(Str::plural(preg_replace('/.*\\\/', '', self::class)));
    // }
    

    public static function search($columns, $string)
    {
        Generic::ensureArray($columns);

        // $columns = self::getColumnNames();
        // return self::query()
        //     ->where(function($query) use ($columns, $string) {
        //         foreach($columns as $column) {
        //             $query->orWhere($column, 'LIKE', "%{$string}%");
        //         }
        //     });

        return self::query()
            ->where(function (Builder $query) use ($columns, $string) {
                foreach ($columns as $column) {
                    $query->when(
                        str_contains($column, '.'),
                        function (Builder $query) use ($column, $string) {
                            [$relationName, $relationColumn] = explode('.', $column);
        
                            $query->orWhereHas($relationName, function (Builder $query) use ($relationColumn, $string) {
                                $query->where($relationColumn, 'LIKE', "%{$string}%");
                            });
                        },
                        function (Builder $query) use ($column, $string) {
                            $query->orWhere($column, 'LIKE', "%{$string}%");
                        }
                    );
                }
            });

    }
        
}
