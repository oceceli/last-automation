<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;

class Product extends Model
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
        $id = self::getRequestID(); // use for unique keys on update event
        return [
            'data' => [
                'code' => ['required', 'min:2', 'unique:products,code'],
                'barcode' => ['required', 'numeric', 'unique:products,barcode'],
                'name' => ['required', 'min:3'],
                'shelf_life' => 'required',
                'producible' => 'required',
                'is_active' => 'required',
                'min_threshold' => 'nullable',
                'note' => 'nullable',
            ],
            'relation' => [ // use for many to many relationships
                //
            ],
        ];
    }


    public function stockmoves()
    {
        return $this->hasMany(StockMove::class);
    }

    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }
    
}
