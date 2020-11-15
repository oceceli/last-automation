<?php

namespace App\Models;

use App\Common\Facades\Conversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use Carbon\Carbon;

class WorkOrder extends Model
{
    use HasFactory, SoftDeletes, ModelHelpers;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    // protected $with = ['product'];

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
                'is_active' => 'required|boolean',
                'in_progress' => 'nullable|boolean',
                'note' => 'nullable',
            ],
            'relation' => [ // use for many to many relationships
                //
            ],
        ];
    }

    public function setDatetimeAttribute($value) 
    {
        $this->attributes['datetime'] = Carbon::parse($value)->format('d.m.Y');
    }

    public function getDatetimeAttribute($value)
    {
        return Carbon::parse($value)->format('d.m.Y');
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = (boolean)$value;
    }
    public function getIsActiveAttribute($value)
    {
        return (boolean)$value;
    }

    public function isCompleted()
    {
        return $this->is_completed;
    }
    public function isNotCompleted()
    {
        return !$this->isCompleted();
    }


    public function inProgress()
    {
        return $this->in_progress;
    }

    /**
     * Put selected work-order into production 
     */
    public function start()
    {
        $this->update(['in_progress' => true]);
    }

    /**
     * Put selected work-order out of production and mark as completed
     */
    public function end()
    {
        $this->update(['in_progress' => false, 'is_completed' => true]);
    }

    /**
     * Return updated_at date if production started
     */
    public function startedAt()
    {
        return $this->inProgress()
            ? $this->updated_at // ???
            : false;
        
    }

    public function completedAt()
    {
        return $this->is_completed
            ? $this->updated_at->diffForHumans() // ???
            : false;
    }

    /**
     * Get work-orders of today
     */
    public static function getTodaysList()
    {
        return self::where('datetime', Carbon::today()->format('d.m.Y'))
            ->orderBy('queue', 'asc')
            ->get(); // ve yalnızca aktif olanları al
    }

    public static function getInProgress()
    {
        return (self::where('in_progress', true)->first());
    }


    /**
     * Workorder units 
     */
    private function convertToBase()
    {
        return Conversions::toBase($this->unit, $this->amount);
    }
    public function convertedUnit()
    {
        return $this->convertToBase()['unit'];
    }
    public function convertedAmount()
    {
        return $this->convertToBase()['amount'];
    }





    

}
