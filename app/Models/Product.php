<?php

namespace App\Models;

use App\Models\Traits\HasInventory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;

class Product extends Model
{
    use HasFactory;
    use ModelHelpers;
    use HasInventory;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    // protected $with = ['units', 'recipe'];

        
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }

    public function workorders()
    {
        return $this->hasMany(WorkOrder::class);
    }
    
    public function dispatchProducts()
    {
        return $this->hasMany(DispatchProduct::class);
    }

    public function units() 
    {
        return $this->hasMany(Unit::class); 
    }
    
    public function stockmoves()
    {
        return $this->hasMany(StockMove::class);
    }
    
    
    
    public function scopeWithThreshold($query)
    {
        return $query->whereNotNull('prd_min_threshold');
    }

    public function scopeHasRecipe($query)
    {
        return $query->has('recipe');
    }

    

    public function getIsActiveAttribute($value) 
    {
        return $value == 1 ? true : false;
    }

    public function getProducibleAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    
    public function getBaseUnitAttribute()
    {
        return $this->units()->where('is_base', true)->first();
    }

    // public function getBaseUnitAttribute() // !! üsttekinde sorun çıkabilir
    // {
    //     return $this->units()->where('parent_id', 0)->first();
    // }



    public function getLastCreatedWorkOrder()
    {
        return $this->workorders()->latest()->first();
    }

    // public function getRecipeIngredients() // !! hiç kullanılmamış
    // {
    //     $array = [];
    //     if($this->recipe()->exists() && $this->recipe->ingredients()->exists()) {
    //         foreach($this->recipe->ingredients as $ingredient) {
    //             $ingredients[] = $ingredient;
    //             $amounts[] = $ingredient->pivot->amount;
    //             $units[] = $ingredient->pivot->unit_id;
    //         }
    //         $array['ingredients'] = $ingredients;
    //         $array['amounts'] = $amounts;
    //         $array['units'] = $units;
    //     }
    //     return $array;
    // }


    public function isProducible()
    {
        return $this->prd_producible;
    }


    public function setPrdCodeAttribute($prd_code)
    {
        $this->attributes['prd_code'] = strtoupper($prd_code);
    }
    public function getPrdCodeAttribute($prd_code)
    {
        return strtoupper($prd_code);
    }
    

    public function setPrdNameAttribute($prd_name)
    {
        $this->attributes['prd_name'] = ucwords($prd_name);
    }
    public function getPrdNameAttribute($prd_name)
    {
        return ucwords($prd_name);
    }

    
    
}
