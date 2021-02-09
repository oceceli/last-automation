<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dispatchOrders()
    {
        return $this->hasMany(DispatchOrder::class);
    }
}
