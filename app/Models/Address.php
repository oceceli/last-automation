<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function adressable()
    {
        return $this->morphTo();
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = strtoupper($value);
    }

    public function getCountryAttribute($value)
    {
        return strtoupper($value);
    }

    public function setProvinceAttribute($value)
    {
        $this->attributes['province'] = ucfirst($value);
    }
    public function getProvinceAttribute($value)
    {
        return ucfirst($value);
    }
}
