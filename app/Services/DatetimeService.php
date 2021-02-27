<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class DatetimeService
{
    public static function createdBetween(Builder $query, $from, $to = null)
    {
        if($to == null) $to = now();
        return $query->whereBetween('created_at', [$from, $to]);
    }
}