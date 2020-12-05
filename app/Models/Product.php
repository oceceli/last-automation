<?php

namespace App\Models;

use App\Models\Traits\HasInventory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;

class Product extends Model
{
    use HasFactory, SoftDeletes, ModelHelpers;
    use HasInventory;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = ['units', 'recipe']; 


    // public const theadAttributes = [
    //     'Sıra', 'Ürün Adı', 'Kod', 'Barkod', 'Raf Ömrü', 'Min. Stok', 'Aktif', 'Üretilebilir',
    // ];

        
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    /**
     * Validate rules for current model
     */
    public static function rules()
    {
        $id = self::getRequestID(); // use for unique keys on update event
        return [
            'data' => [
                'category_id' => 'required|integer',
                'code' => 'required|min:1|unique:products,code',
                'barcode' => 'nullable|numeric|unique:products,barcode',
                'name' => 'required|min:1',
                'shelf_life' => 'required|numeric',
                'producible' => 'required|boolean',
                'is_active' => 'sometimes|nullable|boolean',
                'min_threshold' => 'nullable|numeric',
                'note' => 'nullable',
            ],
            'relation' => [ // use for many to many relationships
                //
            ],
        ];
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
    /**
     * A bridge for the recipe ingredients 
     */
    public function getIngredientsAttribute()
    {
        return $this->recipe->ingredients;
    }

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
        return self::where('producible', true)
            ->orderBy('code', 'asc')
            ->get();
    }

    public function getCodeAttribute($value)
    {
        return strtoupper($value);
    }
    
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    
    
}
