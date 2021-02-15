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
use Carbon\Carbon;

class WorkOrder extends Model implements CanReserveStocks
{
    use HasFactory;
    use ModelHelpers;
    use Searchable;
    use FinalizeProduction;
    use FinalizedProduction;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = ['product'];

    protected $casts = ['wo_datetime' => 'datetime', 'wo_started_at' => 'datetime', 'wo_finalized_at' => 'datetime'];


    // @override
    // public function delete()
    // {
    //     if($this->isInProgress()) return;

    //     $this->reservedStocks()->delete(); // !!! silme kuralları observe'e eklenecek
        
    //     if($this->isFinalized()) {
    //         $this->stockMoves()->delete();
    //     }
    //     parent::delete();
    // }


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


    public function setWoDatetimeAttribute($value) 
    {
        $this->attributes['wo_datetime'] = Carbon::parse($value)->format('d.m.Y');
    }



    public function getWoDatetimeAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y');
    }



    /**
     * $workOrder->statusColor
     */
    public function getStatusColorAttribute()
    {
        return [
            'active' => 'blue',
            'suspended' => 'gray',
            'in_progress' => 'yellow',
            'completed' => 'green',
        ][$this->wo_status] ?? null;
    }


    /**
     * Return work order finalized status
     */
    public function isFinalized()
    {
        return $this->wo_status === 'completed' && $this->wo_finalized_at;
    }


    /**
     * Return is work order active
     */
    public function isActive()
    {
        return $this->wo_status === 'active';
    }


    /**
     * Return is work order suspended
     */
    public function isSuspended()
    {
        return $this->wo_status === 'suspended';
    }


    /**
     * Suspend work order, so it will be non-producible until unsuspend again
     */
    public function suspend()
    {
        if( ! $this->isFinalized() && ! $this->isInProgress() && $this->update(['wo_status' => 'suspended'])) 
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
     * Return is progress started
     */
    public function isInProgress() : bool
    {
        return $this->wo_status === 'in_progress' && isset($this->wo_started_at);
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
            $this->update(['wo_finalized_at' => now(), 'wo_status' => 'completed']);
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
    public function finalizedAt()
    {
        return $this->isFinalized()
            ? $this->wo_finalized_at->diffForHumans() // ???
            : false;
    }



    public function isToday() // ??? patlamış olabilir
    {
        return $this->wo_datetime == Carbon::today()->format('d.m.Y');
    }



    /**
     * Get work-orders of today
     */
    public static function getTodaysList()
    {
        return self::where('wo_datetime', Carbon::today()->format('d.m.Y'))
            ->orWhere('wo_status', 'in_progress')
            ->orderBy('wo_queue', 'asc')
            ->get();
    }

    // public static function reservedLots()
    // {
    //     // todo: işi başlatmadan önce ayırtılmış lotları çek 
    //     StockMove::where()
    // }



    public static function inProgressCurrently()
    {
        return self::where('wo_status', 'in_progress')->first();
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
