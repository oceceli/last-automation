<?php

namespace App\Models;

use App\Models\Interfaces\CanReserveStocks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchProduct extends Model implements CanReserveStocks
{
    use HasFactory;

    protected $guarded = [];

    protected $touches = ['dispatchOrder']; // !  kontrol etmedim

    public function dispatchOrder()
    {
        return $this->belongsTo(DispatchOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    

    public function setReady()
    {
        $this->dispatchOrder->setInProgress();
        return $this->update(['dp_is_ready' => true]);
    }

    
    public function undoReady()
    {
        $this->reservedStocks()->delete();

        $this->update(['dp_is_ready' => false]);
        
        // whenever emptied prepared lots, we must detect and set dispatchorder's progress status as in_progress or active in case of if any other product/products are ready
        $this->dispatchOrder->detectIsInProgress();
    }


    public function isReady()
    {
        return $this->dp_is_ready;
    }


    
    public function stockMoves()
    {
        // faking it, for able to use reserved stocks table component
    }


    /**
     * Calls reservedstocks depend on product
     */
    public function reservedStocks()
    {
        return $this->dispatchOrder->reservedStocks()
            ->where('product_id', $this->product_id);
    }


    /**
     * Works just like this pivot model has relation to reservedstocks table
     */
    public function getReservedStocksAttribute()
    {
        return $this->reservedStocks()->get();
    }

}
