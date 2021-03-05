<?php

namespace App\Services\Product;

use App\Models\Product;

class ProductService
{
    public static function getProducibleProducts()
    {
        return Product::where('prd_producible', true)->get();
    }


    public static function getProducibleOnes()
    {
        return Product::where('prd_producible', true)
            ->select(['id', 'prd_code', 'prd_name'])
            ->orderBy('prd_name', 'asc')
            ->get();
    }
}