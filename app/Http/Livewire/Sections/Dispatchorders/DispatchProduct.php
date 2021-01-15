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

    public $selectedProduct;

    public function getProductsProperty()
    {
        return Product::all();
    }

    public function updatedProductId($id)
    {
        $this->selectedProduct = Product::find($id);
        $this->emit('dp_product_selected');

    }

    public function getLotsProperty()
    {
        $lotNumbers = (new LotNumberService($this->selectedProduct))->allWithAmounts();
        return $lotNumbers;
        // return StockMove::where('product_id', $this->product_id)->pluck('lot_number')->toArray(); // !! güncellenecek
    }

}