<?php

namespace App\Http\Livewire\Traits\DispatchOrders;

use App\Common\Facades\Conversions;
use App\Models\Product;

trait SpecifyProducts
{

    public $staticSelectedProduct;

    // public $spModal = false;

    // model cards
    public $cards;

    protected $spRules = [
        'cards' => 'array',
        'cards.*.product_id' => 'required|integer',
        'cards.*.dp_amount' => 'required|numeric',
        'cards.*.unit_id' => 'required|integer',
    ];



    protected function spValidationAttributes()
    {
        return [
            'cards.*.product_id' => __('products.product'),
            'cards.*.dp_amount' => __('common.amount'),
            'cards.*.unit_id' => __('units.unit'),
        ];
    }


    
    // public function openSpModal()
    // {
    //     $this->spModal = true;
    // }


    public function getProductsProperty()
    {
        return Product::select('id', 'name', 'code')->get();
    }



    
    public function addCard()
    {
        $this->cards[] = [
            'product_id' => null,
            'dp_amount' => null,
            'unit_id' => null,
        ];
    }


    public function getCountFilledCards()
    {
        return count(array_filter(array_column($this->cards, 'product_id')));
    }


     /**
     * Nested product_id on updated event 
     * Fill out the units dropdown based on selected product 
     */
    public function updatedCards($id, $location)
    {
        if(strpos($location, 'product_id')) {
            $index = strtok($location, '.');
            $this->staticSelectedProduct = $this->getProductsProperty()->find($id);
            $this->emit('sp_product_selected'.$index);
            
            // set base unit as default unit, also user will be able to change unit in dropdown
            $this->cards[$index]['unit_id'] = $this->staticSelectedProduct->baseUnit->id;
        }
    }





    public function removeCard($id)
    {
        if(count($this->cards) > 1)
            unset($this->cards[$id]);
    }





    public function getUnitsProperty()
    {
        return $this->staticSelectedProduct->units->toArray();
    }





    private function spSubmit($dispatchOrder)
    {
        foreach($this->cards as $card) {
            // $baseAmount = Conversions::toBase($card['unit_id'], $card['dp_amount'])['amount'];
            $dispatchOrder->dispatchProducts()->create([
                'product_id' => $card['product_id'],
                'dp_amount' => $card['dp_amount'],
                'unit_id' => $card['unit_id'],
            ]);
        }
        return true;
    }





    private function spProductsEditMode($dispatchOrder)
    {
        foreach($dispatchOrder->dispatchProducts as $key => $dp) {
            $this->cards[] = [
                'product_id' => $dp->product_id,
                'dp_amount' => $dp->dp_amount,
                // 'unit_id' => $dp->product->baseUnit->id,
            ];
            // $this->updatedCards((int)$dp->product_id, "$key.product_id");
        }
    }

}


