<?php

namespace App\Http\Livewire\Traits\Dashboard;

use App\Models\Product;

trait MinThreshold
{
    public function getCriticalStockProductsProperty()
    {
        $products = [];
        foreach (Product::withThreshold()->get() as $product) {
            if($product->totalStock['amount'] < $product->prd_min_threshold) {
                $products[] = $product;
            }
        }
        return collect($products);
    }
}
