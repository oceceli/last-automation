<?php 

namespace App\Services\Stock;

use App\Models\Product;
use App\Models\StockMove;
use Illuminate\Database\Eloquent\Builder;

class LotNumberService
{
    private Product $product;
    

    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    /**
     * Get total amount of updirection stockmoves
     */
    private function positive($lot) : float
    {
        return StockMove::where([
            'product_id' => $this->product->id, 
            'lot_number' => $lot,
            'direction' => true,
        ])->sum('base_amount');
    }

    /**
     * Get total amount of downdirection stockmoves
     */
    private function negative($lot) : float
    {
        return StockMove::where([
            'product_id' => $this->product->id, 
            'lot_number' => $lot,
            'direction' => false,
        ])->sum('base_amount');
    }

    /**
     * Return actual amount of given lot
     */
    public function inStock($lot)
    {
        return $this->positive($lot) - $this->negative($lot);
    }

    /**
     *  Drops down into one all stockmove lot occurrences
     * 
     * @return array unique lot numbers
     */
    private function uniqueLots()
    {
        return StockMove
            ::where(['product_id' => $this->product->id])
            ->select('lot_number')
            ->distinct()
            ->get()->pluck('lot_number');
    }


    /**
     * @return array lot numbers and amounts
     */
    public function withAmounts()
    {
        $arr = [];
        foreach($this->uniqueLots() as $lot) {
            $amount = $this->inStock($lot);
            if($amount <= 0) continue;

            $arr[] = [
                'lot_number' => $lot, 
                'amount' => $amount,
            ];
        }
        return $arr;
    }

    // get lots which have positive amounts
    // get lots which have negative amounts
    // sum amounts and substract them
    // find product's all lot occurrences as unique 
    // find actual amount each given lot
    // push them into array

}