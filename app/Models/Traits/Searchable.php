<?php 

namespace App\Models\Traits;

use App\Common\Helpers\Generic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


trait Searchable
{

    // /**
    //  * Get current table's column names.
    //  */
    // public static function getColumnNames()
    // {
    //     $array = Schema::getColumnListing(Str::plural(Generic::toSnakeCase(self::class)));
    //     $idsAppended = [];

    //     // find '_id' appended attributes. Will be extracted from search index
    //     foreach($array as $item) {
    //         if(Generic::detectIdAppending($item)) $idsAppended[] = $item;
    //     }

    //     // extract unnecessary attributes from index
    //     return array_values(array_diff($array, array_merge(['id', 'created_at', 'updated_at'], $idsAppended)));

    // }
    

    // public static function search($string, array $related = [], $query = null)
    // {
    //     $columns = array_merge(self::getColumnNames(), $related);

    //     $query = $query ? $query : self::query();

    //     return $query
    //         ->where(function (Builder $query) use ($columns, $string) {
    //             foreach ($columns as $column) {
    //                 $query->when(
    //                     str_contains($column, '.'),
    //                     function (Builder $query) use ($column, $string) {
    //                         [$relationName, $relationColumn] = explode('.', $column);
        
    //                         $query->orWhereHas($relationName, function (Builder $query) use ($relationColumn, $string) {
    //                             $query->where($relationColumn, 'LIKE', "%{$string}%");
    //                         });
    //                     },
    //                     function (Builder $query) use ($column, $string) {
    //                         $query->orWhere($column, 'LIKE', "%{$string}%");
    //                     }
    //                 );
    //             }
    //         });

    // }

    
}