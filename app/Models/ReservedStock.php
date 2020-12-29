<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedStock extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = []; 


    public function workorder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Product::class, null, null, 'ingredient_id'); // ?? doğru mu emin değilim
    }

}
