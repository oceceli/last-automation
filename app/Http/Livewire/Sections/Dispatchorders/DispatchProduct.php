<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Models\Product;
use App\Models\StockMove;
use App\Services\Stock\LotNumberService;

trait DispatchProduct
{
    public $dp_lot_number;
    public $dp_amount;

    public $unit_id;
    public $product_id;
    public $dispatch_order_id;

    public $selectedProduct; // ! kullanımdışı

    public function getProductsProperty()
    {
        return Product::all();
    }

    public function updatedProductId($value)
    {
        $this->selectedProduct = Product::find($value);
        $this->emit('dp_product_selected');
        dd((new LotNumberService($this->selectedProduct))->inStock());

    }

    public function getLotsProperty()
    {
        return StockMove::where('product_id', $this->product_id)->pluck('lot_number')->toArray(); // !! güncellenecek
    }

}