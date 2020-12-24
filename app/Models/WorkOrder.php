<?php

namespace App\Models;

use App\Common\Facades\Conversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use App\Models\Traits\Production;
use App\Models\Traits\Searchable;
use Carbon\Carbon;

class WorkOrder extends Model
{
    use HasFactory, SoftDeletes, ModelHelpers;
    use Searchable;
    use Production;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = ['product'];

    protected $casts = ['datetime' => 'date', 'started_at' => 'datetime', 'finalized_at' => 'datetime'];


    // @override
    public function delete()
    {
        // $this->preferredStocks()->delete(); // ???? silme kuralları eklenecek
        if($this->isFinalized()) {
            $this->stockMoves()->delete();
        }
        parent::delete();
    }


    public function stockMoves()
    {
        return $this->morphMany('App\Models\StockMove', 'stockable');
    }


    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function preferredStocks()
    {
        return $this->hasMany(PreferredStock::class);
    }


    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }



    public function setDatetimeAttribute($value) 
    {
        $this->attributes['datetime'] = Carbon::parse($value)->format('d.m.Y');
    }



    public function getDatetimeAttribute($value)
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
        ][$this->status] ?? null;
    }



    /**
     * Return work order finalized status
     */
    public function isFinalized()
    {
        return isset($this->finalized_at); 
        // return $this->status === 'completed';
    }


    /**
     * Return is work order active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }


    /**
     * Return is work order suspended
     */
    public function isSuspended()
    {
        return $this->status === 'suspended';
    }


    /**
     * Suspend work order, so it will be non-producible until unsuspend again
     */
    public function suspend()
    {
        if( ! $this->isFinalized() && ! $this->isInProgress() && $this->update(['status' => 'suspended'])) 
            return true;
    }


    /**
     * Unsuspend the workorder, it can get into in_progress
     */
    public function unsuspend()
    {
        if($this->update(['status' => 'active']))
            return true;
    }
    


    /**
     * Return is progress started
     */
    public function isInProgress() : bool
    {
        return $this->status === 'in_progress' && isset($this->started_at);
    }



    /**
     * Put selected work-order into production 
     */
    public function start()
    {
        if($this->isActive() && ! $this->inProgressCurrently()) { // !! aynı anda bir çok iş başlayabilir, onu aç sonra
            $this->update(['status' => 'in_progress', 'started_at' => now()]);
            return true;
        }
    }
    


    /**
     * Put selected work-order out of production and mark as finalized
     */
    public function markAsFinalized()
    {
        if($this->isInProgress())
            $this->update(['finalized_at' => now(), 'status' => 'completed']);
            // $this->update(['status' => 'completed']);
    }

    

    /**
     * Return started_at date if production has started
     */
    public function startedAt()
    {
        return $this->isInProgress() ? $this->started_at : null; // ??
    }


    /**
     * Return finalized_at column for humans
     */
    public function finalizedAt()
    {
        return $this->isFinalized()
            ? $this->finalized_at->diffForHumans() // ???
            : false;
    }



    public function isToday() // ??? patlamış olabilir
    {
        return $this->datetime == Carbon::today()->format('d.m.Y');
    }



    /**
     * Get work-orders of today
     */
    public static function getTodaysList()
    {
        return self::where('datetime', Carbon::today()->format('d.m.Y'))
            ->orWhere('status', 'in_progress')
            ->orderBy('queue', 'asc')
            ->get();
    }


    public static function inProgressCurrently()
    {
        return self::where('status', 'in_progress')->first();
    }

    
    public function unitIsAlreadyBase()
    {
        return Conversions::toBase($this->unit, $this->amount)['unit'] == $this->unit;
    }

    public function convertedBaseUnit()
    {
        return Conversions::toBase($this->unit, $this->amount)['unit'];
    }

    public function convertedBaseAmount()
    {
        return Conversions::toBase($this->unit, $this->amount)['amount'];
    }







    

}
