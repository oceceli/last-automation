<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dispatchOrder()
    {
        return $this->belongsTo(DispatchOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    

    public function setReady()
    {
        return $this->update(['dp_is_ready' => true]);
    }
}
