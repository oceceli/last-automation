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

    public function delete()
    {
        $this->addresses()->delete();
        parent::delete();
    }

    public function getTypeAttribute()
    {
        // if($this->cmp_supplier && $this->cmp_customer) // !! ikisinin de olduğu durumda veya ikisininde olmadığı durumda ?
        if($this->cmp_supplier) return __('validation.attributes.cmp_supplier');
                                return __('validation.attributes.cmp_customer');
    }

    public function getCmpSupplierAttribute($supplier)
    {
        return (boolean)$supplier;
    }

    public function getCmpCustomerAttribute($customer)
    {
        return (boolean)$customer;
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
