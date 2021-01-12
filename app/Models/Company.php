<?php

namespace App\Models;

use App\Models\Traits\ModelHelpers;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    use Searchable;
    use ModelHelpers;

    protected $guarded = [];

    protected $with = ['addresses'];

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    // public function setCmpNameAttribute($attribute)
    // {
    //     $this->attributes['cmp_name'] = strtolower($attribute);
    // }
    // public function getCmpNameAttribute($attribute)
    // {
    //     return ucfirst($attribute);
    // }

    // public function setCmpCommercialTitleAttribute($attribute)
    // {
    //     $this->attributes['cmp_commercial_title'] = strtolower($attribute);
    // }
    // public function getCmpCommercialTitleAttribute($attribute)
    // {
    //     return strtoupper($attribute);
    // }

}
