<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use App\Models\Traits\Searchable;

class Category extends Model
{
    use HasFactory, ModelHelpers;
    use Searchable;

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

    // public static function getCategoriesWithProducts()
    // {
    //     return self::has('products', '>', 0)->get();

    //     // ->whereHas('products', function($query){
    //     //     $query->where('producible', false);
    //     // })
    // }

    /**
     * Validate rules for current model
     */
    // public static function rules()
    // {
    //     return [
    //         'data' => [
    //             'name' => 'required|unique:categories',
    //         ],
    //         'relation' => [ // use for many to many relationships
    //             //
    //         ],
    //     ];
    // }

    public function setNameAttribute($value) 
    {
        $this->attributes['name'] = ucwords($value);
    }
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
    
}
