<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;

class Recipe extends Model
{
    use HasFactory, SoftDeletes, ModelHelpers;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = ['product']; 

    /**
     * Validate rules for current model
     */
    public static function rules()
    {
        $id = self::getRequestID(); // use for unique keys on update event
        return [
            'data' => [
                //
            ],
            'relation' => [ // use for many to many relationships
                //
            ],
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function contents()
    {
        return $this->belongsToMany(Product::class)->withPivot('amount');
    }

    public function workorders()
    {
        return $this->hasMany(WorkOrder::class);
    }
    
}
