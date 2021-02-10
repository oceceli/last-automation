<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchExtra extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dispatchOrder()
    {
        return $this->belongsTo(DispatchOrder::class);
    }
}
