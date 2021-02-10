<?php

namespace App\Models;

use App\Models\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesType extends Model
{
    use HasFactory;
    use ModelHelpers;

    protected $guarded = [];

    public function dispatchOrders()
    {
        return $this->hasMany(DispatchOrder::class);
    }


    // public function setStNameAttribute($value)
    // {
    //     $this->attributes['st_name'] = ucwords($value);
    // }

    // public function getStNameAttribute($value)
    // {
    //     return ucwords($value);
    // }

    // public function setStAbbrAttribute($value)
    // {
    //     $this->attributes['st_abbr'] = strtoupper($value);
    // }

    // public function getStAbbrAttribute($value)
    // {
    //     return strtoupper($value);
    // }
}
