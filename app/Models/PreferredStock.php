<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferredStock extends Model
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

}
