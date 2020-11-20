<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
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

    /**
     * Validate rules for current model
     */
    // public static function rules()
    // {
    //     // $id = self::getRequestID(); // use for unique keys on update event
    //     return [
    //         'data' => [
    //             'product_id' => 'required|min:1|integer',
    //             'stockable_id' => 'required|min:1|integer',
    //             'stockable_type' => 'required|max:30',
    //             'type' => 'required|max:30',
    //             'direction' => 'required|boolean',
    //             'amount' => 'required|numeric',
    //             'datetime' => 'required|date',
    //         ],
    //         'relation' => [ // use for many to many relationships
    //             //
    //         ],
    //     ];
    // }

    public function stockable()
    {
        return $this->morphTo();
    }

    public function isProduction()
    {
        if($this->stockable_type === "App\Models\WorkOrder") // veritabanına type adında yeni bir column oluştur
            return true;
        return false;
    }

    public function product() 
    {
        return $this->belongsTo(Product::class);
    }

    public function setDatetimeAttribute($datetime)
    {
        $this->attributes['datetime'] = Carbon::parse($datetime); // ???
    }
    public function getDatetimeAttribute($datetime)
    {
        return Carbon::parse($datetime)->format('d.m.Y H:i:s'); // ??
    }

    
}
