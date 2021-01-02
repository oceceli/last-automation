<?php

namespace App\Models;

use App\Common\Facades\Conversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use App\Models\Traits\Searchable;

class Recipe extends Model
{
    use HasFactory, ModelHelpers;
    use Searchable;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = ['ingredients']; 

    /**
     * Validate rules for current model
     */
    // public static function rules()
    // {
    //     $id = self::getRequestID(); // use for unique keys on update event
    //     return [
    //         'data' => [
    //             'product_id' => 'required|min:1',
    //             'code' => 'required|unique:recipes',
    //         ],
    //         'relation' => [ // use for many to many relationships
    //             //
    //         ],
    //     ];
    // }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Product::class)->withPivot('amount', 'unit_id', 'literal');
    }

    public function setCodeAttribute($code)
    {
        $this->attributes['code'] = strtoupper($code);
    }

    public function getToleranceFactorAttribute()
    {
        return 3; // !! todo: bunu veritabanına taşımam gerekiyor 
    }
    

    public function delete()
    {
        if($this->recipeUsedInActiveWorkOrders() > 0) {
            return ['message' => '!!! Bu reçeteye ait aktif iş emri/emrileri olduğu için silinemez!', 'type' => 'error'];
        } 
            
        $this->ingredients()->detach();
        parent::delete();
        return ['message' => __('sections/recipes.recipe_deleted_successfully'), 'type' => 'success'];
        
        
    }

    private function recipeUsedInActiveWorkOrders() 
    {
        return WorkOrder::where('product_id', $this->product->id)
                        ->where(function($query){
                            $query->where('status', 'active')
                                  ->orWhere('status', 'suspended')
                                  ->orWhere('status', 'in_progress');
                        })->count();
    }


    public function calculateNecessaryIngredients($amount, $unitId) : array
    {
        $mainProduct = Conversions::toBase($unitId, $amount);
        foreach($this->ingredients as $key => $ingredient) {
            $convertedIngredient = Conversions::toBase($ingredient->pivot->unit_id, $ingredient->pivot->amount);
            $array[] = [
                'ingredient' => $ingredient,
                'amount' => $mainProduct['amount'] * $convertedIngredient['amount'],
                'unit' => $convertedIngredient['unit'],
            ];
        }

        return $array;
    }


    // public function getNeedsAttribute()
    // {
    //     foreach($this->ingredients as $ingredient) {
    //         $array[] = [
    //             'ingredient' => $ingredient,
    //             'amount' => $ingredient->pivot->amount,
    //             'unit' => Unit::find($ingredient->pivot->unit_id)
    //         ];
    //     }
    //     return $array;
    // }

    
}



// $array[$key] = [
//     'ingredient' => $ingredient,
//     'amount' => $mainProduct['amount'] * $convertedIngredient['amount'],
//     'actual_amount' => $mainProduct['amount'] * $convertedIngredient['amount'],
//     'unit' => $convertedIngredient['unit'],
// ];
// if( ! $ingredient->pivot->literal) 
//     $array[$key]['amount'] = floor($mainProduct['amount'] * $convertedIngredient['amount']); // floor
