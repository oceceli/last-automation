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

    // protected $casts = ['cmp_supplier' => 'boolean', 'cmp_customer' => 'boolean'];

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function dispatchorders()
    {
        return $this->hasMany(DispatchOrder::class);
    }

    public function delete()
    {
        $this->addresses()->delete();
        parent::delete();
    }
    
    public function setCmpCommercialTitleAttribute($value)
    {
        $this->attributes['cmp_commercial_title'] = strtoupper($value);
    }

    public function getCmpCommercialTitleAttribute($value)
    {
        return strtoupper($value);
    }
    
    public function setCmpNameAttribute($value)
    {
        $this->attributes['cmp_name'] = ucwords($value);
    }

    public function getCmpNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getCmpSupplierAttribute($supplier)
    {
        return (boolean)$supplier;
    }

    public function getCmpCustomerAttribute($customer)
    {
        return (boolean)$customer;
    }



}
