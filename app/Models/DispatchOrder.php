<?php

namespace App\Models;

use App\Models\Interfaces\CanReserveStocks;
use App\Models\Traits\DispatchOrder\DispatchOrderRules;
use App\Models\Traits\DispatchOrder\DispatchStates;
use App\Models\Traits\ModelHelpers;
use App\Models\Traits\Searchable;
use App\Services\Address\AddressService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchOrder extends Model implements CanReserveStocks
{
    use HasFactory;
    use Searchable;
    use DispatchStates;
    use DispatchOrderRules;
    use ModelHelpers;
    

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function reservedStocks()
    {
        return $this->morphMany(ReservedStock::class, 'reservable');
    }

    public function dispatchProducts()
    {
        return $this->hasMany(DispatchProduct::class);
    }

    public function stockMoves()
    {
        return $this->morphMany('App\Models\StockMove', 'stockable');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }



    public function setDoDatetimeAttribute($value) 
    {
        $this->attributes['do_planned_datetime'] = Carbon::parse($value)->format('d.m.Y');
    }

    public function getDoDatetimeAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y');
    }




    public function isAllReady()
    {
        foreach($this->dispatchProducts as $dispatchProduct) {
            if(! $dispatchProduct->isReady()) 
                return false;
        }
        return true;
    }


    public function fullAddress()
    {
        return AddressService::concatenated($this->address);
    }

}
