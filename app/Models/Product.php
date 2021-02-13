<?php

namespace App\Models;

use App\Models\Traits\HasInventory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;

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
    // protected $with = ['units', 'recipe'];  // !! kapattım hata olabilir

        
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function dispatchorders()
    {
        return $this->belongsToMany(DispatchOrder::class);
    }

    
    // public static function orderByRelationColumn($relation, $direction = 'asc') // !! kullanılmıyor
    // {
    //     $subQuery = 
    //         self::join('categories', 'categories.id', '=', 'products.category_id')
    //         ->orderBy('categories.name', $direction)
    //         ->select('products.*');
    //     return $subQuery;
    // }

    
    /**
     * Validate rules for current model
     */
    // public static function rules()
    // {
    //     $id = self::getRequestID(); // use for unique keys on update event
    //     return [
    //         'data' => [
    //             'category_id' => 'required|integer',
    //             'code' => 'required|min:1|unique:products,code',
    //             'barcode' => 'nullable|numeric|unique:products,barcode',
    //             'name' => 'required|min:1',
    //             'shelf_life' => 'required|numeric',
    //             'producible' => 'required|boolean',
    //             'is_active' => 'sometimes|nullable|boolean',
    //             'min_threshold' => 'nullable|numeric',
    //             'note' => 'nullable',
    //         ],
    //         'relation' => [ // use for many to many relationships
    //             //
    //         ],
    //     ];
    // }

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



    /**
     * A bridge for the recipe ingredients 
     */
    // public function getIngredientsAttribute()
    // {
    //     return $this->recipe->ingredients;
    // }

    public function getBaseUnit()
    {
        return $this->units->where('parent_id', 0)->first();
    }
    public function getBaseUnitAttribute()
    {
        return $this->getBaseUnit();
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
