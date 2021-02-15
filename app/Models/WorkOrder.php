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
use Carbon\Carbon;

class WorkOrder extends Model implements CanReserveStocks
{
    use HasFactory;
    use ModelHelpers;
    use Searchable;

    use WorkOrderStates;
    use FinalizeProduction;
    use FinalizedProduction;

    protected $guarded = [];

    protected $with = ['product'];

    protected $casts = ['wo_datetime' => 'datetime', 'wo_started_at' => 'datetime', 'wo_completed_at' => 'datetime'];




    public function stockMoves()
    {
        return $this->morphMany('App\Models\StockMove', 'stockable');
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function reservedStocks()
    {
        return $this->morphMany(ReservedStock::class, 'reservable');
    }


    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }


    public function setWoLotNoAttribute($value)
    {
        $this->attributes['wo_lot_no'] = strtoupper($value);
    }
    public function getWoLotNoAttribute($value)
    {
        return strtoupper($value);
    }


    // public function setWoDatetimeAttribute($value) 
    // {
    //     $this->attributes['wo_datetime'] = Carbon::parse($value)->format('d.m.Y');
    // }

    // public function getWoDatetimeAttribute($value)
    // {
    //     return Carbon::parse($value)->format('d.m.Y');
    // }


    



    /**
     * Suspend work order, so it will be non-producible until unsuspend again
     */
    public function suspend()
    {
        if( ! $this->isCompleted() && ! $this->isInProgress() && $this->update(['wo_status' => 'suspended'])) 
            return true;
    }


    /**
     * Unsuspend the workorder, it can get into in_progress
     */
    public function unsuspend()
    {
        if($this->update(['wo_status' => 'active']))
            return true;
    }
    


    /**
     * Put selected work-order into production 
     */
    public function start()
    {
        // if($this->isActive() && ! $this->isInProgress() && ! $this->inProgressCurrently()) { // aynı anda bir çok iş başlayabilir, onu aç sonra // * açtım
        if($this->isActive() && ! $this->isInProgress()) {
            $this->update(['wo_status' => 'in_progress', 'wo_started_at' => now()]);
            return true;
        }
    }


    public function abort()
    {
        if($this->isInProgress()) {
            $this->update(['wo_status' => 'active', 'wo_started_at' => null]);
            $this->reservedStocks()->delete();
            return true;
        }
    }
    


    /**
     * Put selected work-order out of production and mark as finalized
     */
    public function markAsFinalized()
    {
        if($this->isInProgress())
            $this->update(['wo_completed_at' => now(), 'wo_status' => 'completed']);
            // $this->update(['status' => 'completed']);
    }

    

    /**
     * Return started_at date if production has started
     */
    public function startedAt()
    {
        return $this->isInProgress() ? $this->wo_started_at : null; // ??
    }


    /**
     * Return finalized_at column for humans
     */
    public function completedAt()
    {
        return $this->isCompleted()
            ? $this->wo_completed_at->diffForHumans() // ???
            : false;
    }


    public function isToday() // ??? patlamış olabilir
    {
        return $this->wo_datetime == Carbon::today()->format('d.m.Y');
    }


    
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
