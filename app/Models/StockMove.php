<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;

class StockMove extends Model
{
    use HasFactory, SoftDeletes, ModelHelpers;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = []; 

    /**
     * Validate rules for current model
     */
    public static function rules()
    {
        // $id = self::getRequestID(); // use for unique keys on update event
        return [
            'data' => [
                'product_id' => 'required|min:1',
                'type' => 'required|max:30',
                'direction' => 'required|boolean',
                'amount' => 'required|numeric',
                'date' => 'required|date',
            ],
            'relation' => [ // use for many to many relationships
                //
            ],
        ];
    }

    public function product() 
    {
        return $this->belongsTo(Product::class);
    }
    
}
