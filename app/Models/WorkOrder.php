<?php

namespace App\Models;

use App\Common\Facades\Conversions;
use App\Models\Interfaces\CanReserveStocks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use App\Models\Traits\Searchable;
use App\Models\Traits\WorkOrder\FinalizedProduction;
use App\Models\Traits\WorkOrder\FinalizeProduction;
use App\Models\Traits\WorkOrder\WorkOrderStates;
use App\Services\Stock\LotTracerService;

class WorkOrder extends Model implements CanReserveStocks
{
    use HasFactory;
    use ModelHelpers;
    use Searchable;

    use WorkOrderStates;
    use FinalizedProduction;

    protected $guarded = [];

    protected $with = ['product'];

    protected $casts = ['wo_datetime' => 'datetime', 'wo_started_at' => 'datetime', 'wo_completed_at' => 'datetime'];

    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }


    public function stockMoves()
    {
        return $this->morphMany('App\Models\StockMove', 'stockable');
    }


    public function reservedStocks()
    {
        return $this->morphMany(ReservedStock::class, 'reservable');
    }




    public function formattedDatetime()
    {
        return $this->wo_datetime->format('d.m.Y');
    }

    public function scopeApproved($query)
    {
        return $query->where('wo_status', 'approved');
    }


    public function setWoLotNoAttribute($value)
    {
        $this->attributes['wo_lot_no'] = strtoupper($value);
    }
    public function getWoLotNoAttribute($value)
    {
        return strtoupper($value);
    }


    public function areAllReady()
    {
        $ingredients = $this->product->recipe->ingredients;
        foreach ($ingredients as $ingredient) {
            if(! $this->areSourcesReadyFor($ingredient->id))
                return false;
        }
        return true;
    }
    

    public function reservationsFor($productId)
    {
        return $this->reservedStocks()->where('product_id', $productId);
    }

    
    public function areSourcesReadyFor($productId)
    {
        return $this->reservationsFor($productId)->exists();
    }


    public function canBeDeleted()
    {
        $stateBool = $this->isSuspended() || $this->isActive() || $this->isApproved();
        $notUsed = ! LotTracerService::isUsedInSomewhereExceptProduction($this->product, $this->wo_lot_no); // !! devam
        return $stateBool && $notUsed;
    }

    public function canBeUpdated()
    {
        return $this->isSuspended() || $this->isActive();
    }


    // public static function filterByProduct($productId) // sil
    // {
    //     return self::where('product_id', $productId);
    // }



    
    public function unitIsAlreadyBase()
    {
        return Conversions::toBase($this->unit, $this->wo_amount)['unit'] == $this->unit;
    }

    public function convertedBaseUnit()
    {
        return Conversions::toBase($this->unit, $this->wo_amount)['unit'];
    }

    public function convertedBaseAmount()
    {
        return Conversions::toBase($this->unit, $this->wo_amount)['amount'];
    }

}
