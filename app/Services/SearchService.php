<?php

namespace App\Services;

use App\Common\Helpers\Generic;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class SearchService
{


    public static function search(Builder $query, string $string, array $searchFields)
    {
        return $query
            ->where(function (Builder $query) use ($searchFields, $string) {

                foreach ($searchFields as $column) {
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