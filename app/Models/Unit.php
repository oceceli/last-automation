<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;

class Unit extends Model
{
    use HasFactory, ModelHelpers;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = []; 


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }


    public static function getBaseUnit($productId)
    {
        return self::where(['product_id' => $productId, 'parent_id' => 0])->first();
    }

    /**
     * Validate rules for current model
     */
    public static function rules()
    {
        $id = self::getRequestID(); // use for unique keys on update event
        return [
            'data' => [
                'parent_id' => 'required|int|min:0',
                'product_id' => 'required|int|min:1',
                'name' => 'required|max:20',
                'abbreviation' => 'required|max:10',
                'operator' => 'required|boolean',
                'factor' => 'required|numeric'
            ],
            'relation' => [ // use for many to many relationships
                //
            ],
        ];
    }
    
}
