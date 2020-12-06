<?php

namespace App\Models;

use App\Common\Facades\Conversions;
use App\Models\Traits\HasFormSuggestions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use App\Models\Traits\Production;
use Carbon\Carbon;

class WorkOrder extends Model
{
    use HasFactory, SoftDeletes, ModelHelpers;
    use Production;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = ['product'];

    protected $casts = ['datetime' => 'date'];

    /**
     * Validate rules for current model
     */
    public static function rules()
    {
        // $id = self::getRequestID(); // use for unique keys on update event
        return [
            'data' => [
                'product_id' => 'required|min:1',
                'unit_id' => 'required|min:1',
                'code' => 'required|integer|min:0', // iş emri no
                'lot_no' => 'required',
                'amount' => 'required|numeric|min:0.1',
                'datetime' => 'required|date',
                'queue' => 'required|int|min:0',
                'status' => 'required|max:15',
                'note' => 'nullable',
            ],
            'relation' => [ // use for many to many relationships
                //
            ],
        ];
    }

    public function stockMoves()
    {
        return $this->morphMany('App\Models\StockMove', 'stockable');
    }
    // public function getStockableTypeAttribute()
    // {
    //     return 'App\Models\StockMove';
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
            'inactive' => 'gray',
            'in_progress' => 'yellow',
            'completed' => 'green',
        ][$this->status] ?? null;
    }


    public function isCompleted()
    {
        return $this->status === 'completed';
    }
    public function isNotCompleted()
    {
        return !$this->isCompleted();
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function setActivation($value)
    { 
        // if work order is not completed, then should change the is_active column
        if($this->isNotCompleted() && is_bool($value)) {
            $value
                ? $this->update(['status' => 'active'])
                : $this->update(['status' => 'inactive']);
        }
    }

    public function isInProgress() : bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Put selected work-order into production 
     */
    public function start()
    {
        if($this->isActive() && ! $this->inProgressCurrently()) {
            $this->update(['status' => 'in_progress']);
            return true;
        }
    }

    /**
     * Put selected work-order out of production and mark as completed
     */
    public function markAsCompleted()
    {
        if($this->isInProgress())
            $this->update(['status' => 'completed']);
    }

    

    /**
     * Return updated_at date if production started
     */
    public function startedAt()
    {
        return $this->isInProgress()
            ? $this->updated_at // ???
            : false;
        
    }

    public function completedAt()
    {
        return $this->isCompleted()
            ? $this->updated_at->diffForHumans() // ???
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
