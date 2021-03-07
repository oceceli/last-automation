<?php 

namespace App\Services\Stock;

use App\Models\Product;
use App\Models\StockMove;
use App\Models\WorkOrder;

class LotTracerService
{
    // private $product;
    // private $lot;

    // public function __construct(Product $product, string $lot)
    // {
    //     $this->product = $product;
    //     $this->lot = $lot;
    // }

    public static function firtSeen(string $lot) // ?? bunun gibi şeyler yapılabilir ihtiyaca göre. 
    {
        // $stockMove = StockMove::where([
        //     'product_id' => $this->product->id, 
        //     'lot_number' => $lot, 
        //     'direction' => true,
        // ])->oldest()->get();
        // return [
        //     'date' => $stockMove->created_at,
        //     'type' => $stockMove->stockable(),
        // ];
    }

    public static function isUsedInSomewhereExceptProduction(Product $product, string $lot) : bool
    {
        return StockMove::lotRecords($product, $lot)
            ->whereNotIn('type', ['production_total', 'production_waste'])
            ->downward()
            ->exists();
    }


    public static function isUsingAnyActiveWorkOrder(Product $product, string $lot)
    {
        // return WorkOrder:: // !! devam et
    }


}