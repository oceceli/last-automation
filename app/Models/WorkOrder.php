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
                'recipe_id' => 'required|min:1',
                'code' => 'required|integer|min:0', // iş emri no
                'lot_no' => 'required',
                'amount' => 'required|numeric|min:0.1',
                'datetime' => 'required|date',
                'queue' => 'required|int|min:0',
                'is_active' => 'required|boolean',
                'in_progress' => 'nullable|boolean',
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
