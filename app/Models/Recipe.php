<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;

class Recipe extends Model
{
    use HasFactory, ModelHelpers;

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

    public function delete()
    {
        $this->ingredients()->detach();
        parent::delete();
    }

    public function getNeedsAttribute()
    {
        foreach($this->ingredients as $ingredient) {
            $array[] = [
                'ingredient' => $ingredient,
                'amount' => $ingredient->pivot->amount,
                'unit' => Unit::find($ingredient->pivot->unit_id)
            ];
        }
        return $array;
    }

    
}
