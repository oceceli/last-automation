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

    public function dispatchorders()
    {
        return $this->hasMany(DispatchOrder::class);
    }

    
    public function companyType()
    {
        if($this->cmp_supplier && $this->cmp_customer)
            $type = __('companies.either_supplier_and_customer');
        elseif($this->cmp_supplier)
            $type = __('validation.attributes.cmp_supplier');
        elseif($this->cmp_customer)
            $type = __('validation.attributes.cmp_customer');
        else 
            $type = __('companies.company_type_not_specified');
        return $type;
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


    // public function canBeDeleted()
    // {
        
    // }


}
