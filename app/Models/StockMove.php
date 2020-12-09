<?php

namespace App\Models;

use App\Common\Facades\Conversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use App\Models\Traits\StockCalculations;
use Carbon\Carbon;

class StockMove extends Model
{
    use HasFactory, SoftDeletes, ModelHelpers;

    protected $guarded = [];

    protected $casts = ['datetime' => 'date'];
    

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

    public function isProduction()
    {
        if($this->stockable_type === "App\Models\WorkOrder") // veritabanına type adında yeni bir column oluştur | oluşturdum efendim!
            return true;
        return false;
    }

    public function product() 
    {
        return $this->belongsTo(Product::class);
    }


    // public function unitIsAlreadyBase()
    // {
    //     return Conversions::toBase($this->unit, $this->amount)['unit'] == $this->unit;
    // }

    public function getUnitNameAttribute()
    {
        return $this->product->getBaseUnit()->name;
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

    
}
