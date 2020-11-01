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
    protected $with = ['products']; 


    public function products() 
    {
        return $this->hasMany(Product::class);
    }

    public function unproducibleProducts()
    {
        return $this->products()->where('producible', false);
    }

    // public function producibleProducts()
    // {
    //     return $this->products()->where('producible', true);
    // }

    public static function getCategoriesWithProducts()
    {
        $a =  self::has('products', '>', 0)->get();
        return $a;

        // ->whereHas('products', function($query){
        //     $query->where('producible', false);
        // })
    }

    /**
     * Validate rules for current model
     */
    public static function rules()
    {
        return [
            'data' => [
                'name' => 'required|unique:categories',
            ],
            'relation' => [ // use for many to many relationships
                //
            ],
        ];
    }
    
}
