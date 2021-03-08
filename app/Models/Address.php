<?php

namespace App\Models;

use App\Services\Address\AddressService;
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



    /****************** MUTATORS AND ACCESSORS *****************/

    public function setAdrCountryAttribute($value)
    {
        $this->attributes['adr_country'] = strtoupper($value);
    }

    public function getAdrCountryAttribute($value)
    {
        return strtoupper($value);
    }

    public function setAdrProvinceAttribute($value)
    {
        $this->attributes['adr_province'] = ucfirst($value);
    }
    public function getAdrProvinceAttribute($value)
    {
        return ucfirst($value);
    }

    public function setAdrNameAttribute($value)
    {
        $this->attributes['adr_name'] = ucwords($value);
    }
    public function getAdrNameAttribute($value)
    {
        return ucwords($value);
    }
    
    public function setAdrDistrictAttribute($value)
    {
        $this->attributes['adr_district'] = ucfirst($value);
    }
    public function getAdrDistrictAttribute($value)
    {
        return ucfirst($value);
    }

    public function getFullAddressAttribute()
    {
        return AddressService::concatenated($this);
    }
}
