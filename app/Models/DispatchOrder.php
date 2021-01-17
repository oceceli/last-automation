<?php

namespace App\Models;

use App\Models\Interfaces\CanReserveStocks;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchOrder extends Model implements CanReserveStocks
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function reservedStocks()
    {
        return $this->morphMany(ReservedStock::class, 'reservable');
    }

    public function stockMoves()
    {
        return $this->morphMany('App\Models\StockMove', 'stockable');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
