<?php

namespace App\Models;

use App\Common\Facades\Conversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use App\Models\Traits\Searchable;
use App\Models\Traits\StockMove\HasDeletingRules;

class StockMove extends Model
{
    use HasFactory, SoftDeletes, ModelHelpers;
    use Searchable;
    use HasDeletingRules;

    protected $guarded = [];

    protected $casts = ['datetime' => 'datetime'];
    

    /**
     * Eagerload relationships when retrieving the model
     */
    // protected $with = ['product']; 


    public function stockable()
    {
        return $this->morphTo();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Is current stockmove belongs to a production?
     */
    public function isProduction()
    {
        return $this->stockable_type === "App\Models\WorkOrder";
    }

    public function isDispatch()
    {
        return $this->stockable_type === "App\Models\DispatchOrder";
    }

    public function isTypeManual()
    {
        return $this->type === 'manual';
    }

    public function product() 
    {
        return $this->belongsTo(Product::class);
    }



    public function scopeManualPositive($query)
    {
        return $query->where(['type' => 'manual'])->upward();
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopeUpward($query)
    {
        return $query->where('direction', true);
    }
    
    public function scopeDownward($query)
    {
        return $query->where('direction', false);
    }

    public function scopeLotRecords($query, Product $product, $lotNumber) // !! lot numberservice'i kontrol et
    {
        return $query->where(['product_id' => $product->id, 'lot_number' => $lotNumber])->approved();
    }


    // public function unitIsAlreadyBase()
    // {
    //     return Conversions::toBase($this->unit, $this->amount)['unit'] == $this->unit;
    // }

    public function getUnitNameAttribute()
    {
        return $this->product->baseUnit->name;
    }

    public function setLotNumberAttribute($lotNumber)
    {
        $this->attributes['lot_number'] = strtoupper($lotNumber);
    }

    public function getLotNumberAttribute($lotNumber)
    {
        return strtoupper($lotNumber);
    }

    public function convertToBase()
    {
        return Conversions::toBase($this->unit, $this->amount);
    }

    // public function setDatetimeAttribute($datetime)
    // {
    //     $this->attributes['datetime'] = Carbon::parse($datetime); // ???
    // }
    // public function getDatetimeAttribute($datetime)
    // {
    //     return Carbon::parse($datetime)->format('d.m.Y H:i:s'); // ??
    // }

    

    public static function getCompound($productId, $lotNumber)
    {
        return self::where(['product_id' => $productId, 'lot_number' => $lotNumber])->get();
    }

    public function getSiblingsAttribute()
    {
        return self::where(['product_id' => $this->product_id, 'lot_number' => $this->lot_number]);
    }
    
}
