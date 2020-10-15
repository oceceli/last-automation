<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use Carbon\Carbon;

class WorkOrder extends Model
{
    use HasFactory, SoftDeletes, ModelHelpers;

    protected $guarded = [];

    /**
     * Eagerload relationships when retrieving the model
     */
    protected $with = ['recipe']; 

    /**
     * Validate rules for current model
     */
    public static function rules()
    {
        $id = self::getRequestID(); // use for unique keys on update event
        return [
            'data' => [
                'recipe_id' => 'required',
                'code' => 'required',
                'lot_no' => 'required',
                'amount' => 'required',
                'datetime' => 'date',
                'queue' => 'required',
                'is_active' => 'required',
                'in_progress' => 'nullable',
                'note' => 'nullable',
            ],
            'relation' => [ // use for many to many relationships
                //
            ],
        ];
    }

    public function setDatetimeAttribute($value) 
    {
        $this->attributes['datetime'] = Carbon::parse($value)->format('d.m.Y');
    }

    public function getDatetimeAttribute($value)
    {
        return $value;
        // return Carbon::parse($value)->format('d.m.Y');
    }


    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    

}
