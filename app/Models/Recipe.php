<?php

namespace App\Models;

use App\Common\Facades\Conversions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use App\Models\Traits\Recipe\HasDeletingRules;
use App\Models\Traits\Searchable;

class Recipe extends Model
{
    use HasFactory, ModelHelpers;
    use HasDeletingRules;
    use Searchable;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = ['ingredients']; 

    

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
    



    public function calculateNecessaryIngredients($amount, $unitId) : array
    {
        $mainProduct = Conversions::toBase($unitId, $amount);
        foreach($this->ingredients as $key => $ingredient) {
            $convertedIngredient = Conversions::toBase($ingredient->pivot->unit_id, $ingredient->pivot->amount);
            $array[] = [
                'ingredient' => $ingredient,
                'amount' => $mainProduct['amount'] * $convertedIngredient['amount'],
                'unit' => $convertedIngredient['unit'],
                // 'is_ready' => $ingredient->pivot->is_ready ? true : false,
            ];
        }

        return $array;
    }

}
