<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;

class WorkOrder extends Model
{
    use HasFactory, SoftDeletes, ModelHelpers;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = []; 

    /**
     * Validate rules for current model
     */
    public static function rules()
    {
        $id = self::getRequestID(); // use for unique keys on update event
        return [
            'data' => [
                'recipe_id' => 'required',
                'lot_no' => 'required',
                'amount' => 'required',
                'datetime' => 'required',
                'queue' => 'required',
                'is_active' => 'required',
                'in_progress' => 'required',
                'note' => 'nullable',
            ],
            'relation' => [ // use for many to many relationships
                //
            ],
        ];
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function productName()
    {
        return $this->recipe->product->name;
    }

}
