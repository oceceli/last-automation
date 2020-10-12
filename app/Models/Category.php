<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;

class Category extends Model
{
    use HasFactory, SoftDeletes, ModelHelpers;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = []; 


    public function products() 
    {
        return $this->hasMany(Product::class);
    }

    public function unproducibleProducts()
    {
        return $this->products()->where('producible', false);
    }

    /**
     * Validate rules for current model
     */
    public static function rules()
    {
        $id = self::getRequestID(); // use for unique keys on update event
        return [
            'data' => [
                'name' => 'required',
            ],
            'relation' => [ // use for many to many relationships
                //
            ],
        ];
    }
    
}
