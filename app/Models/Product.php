<?php

namespace App\Models;

use App\Models\Traits\HasInventory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use App\Models\Traits\Searchable;

class Product extends Model
{
    use HasFactory;
    use ModelHelpers;
    use Searchable;
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

    public function dispatchorders()
    {
        return $this->belongsToMany(DispatchOrder::class);
    }


    /**
     * Mutator and accessors **************************************
     */
    public function getIsActiveAttribute($value) 
    {
        return $value == 1 ? true : false;
    }
    public function getProducibleAttribute($value)
    {
        return $value == 1 ? true : false;
    }
    /*********************************************************** */

    public function units() 
    {
        return $this->hasMany(Unit::class); 
    }

    public function stockmoves()
    {
        return $this->hasMany(StockMove::class);
    }

    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }


    // public function getBaseUnit() // !! kullanılıyor olabilir
    // {
    //     return $this->units->where('parent_id', 0)->first();
    // }
    public function getBaseUnitAttribute()
    {
        return $this->units->where('parent_id', 0)->first();
    }


    public function workorders()
    {
        return $this->hasMany(WorkOrder::class);
    }

    public function getLastCreatedWorkOrder()
    {
        return $this->workorders()->latest()->first();
    }

    public function getRecipeIngredients()
    {
        if($this->recipe()->exists() && $this->recipe->ingredients()->exists()) {
            foreach($this->recipe->ingredients as $ingredient) {
                $ingredients[] = $ingredient;
                $amounts[] = $ingredient->pivot->amount;
                $units[] = $ingredient->pivot->unit_id;
            }
            $array['ingredients'] = $ingredients;
            $array['amounts'] = $amounts;
            $array['units'] = $units;
            return $array;
        }
    }

    public static function getProducibleProducts()
    {
        return self::where('producible', true)->get();
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
