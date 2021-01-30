<?php

namespace App\Http\Livewire\Traits\DispatchOrders;

use App\Common\Facades\Conversions;
use App\Models\Product;

trait SpecifyProducts
{
    // public $product_id;
    // public $reserved_amount;

    public $selectedProduct;

    // model cards
    public $cards;

    protected $spRules = [
        'cards.*.product_id' => 'required|integer',
        'cards.*.reserved_amount' => 'required|numeric',
        'cards.*.unitId' => 'required|integer',
    ];

    protected $spValidationAttributes = [ // dil dosyasına geçecek
        'cards.*.product_id' => 'Ürün',
        'cards.*.reserved_amount' => 'Miktar',
        'cards.*.unitId' => 'Birim',
    ];

    public function getProductsProperty()
    {
        return Product::select('id', 'name', 'code')->get();
    }

    public function addCard()
    {
        $this->cards[] = [
            'product_id' => null,
            'reserved_amount' => null,
            'unitId' => null,
        ];
    }

     /**
     * Nested product_id on updated event 
     * Fill out the units dropdown based on selected product 
     */
    public function updatedCards($id, $location)
    {
        if(strpos($location, 'product_id')) {
            $index = strtok($location, '.');
            $this->selectedProduct = $this->getProductsProperty()->find($id);
            $this->emit('sp_product_selected'.$index);
            
            // set base unit as default unit, also user will be able to change unit in dropdown
            $this->cards[$index]['unitId'] = $this->selectedProduct->baseUnit->id; // !! yavaş bilgisayarda seçemiyor olabilir, kontrol et
        }
    }


    public function removeCard($id)
    {
        if(count($this->cards) > 1)
            unset($this->cards[$id]);
    }


    public function getUnitsProperty()
    {
        return $this->selectedProduct->units->toArray();
    }


    private function spSubmit($dispatchOrder)
    {
        foreach($this->cards as $card) {
            $baseAmount = Conversions::toBase($card['unitId'], $card['reserved_amount'])['amount'];
            $dispatchOrder->dispatchProducts()->create([
                'product_id' => $card['product_id'],
                'dp_amount' => $baseAmount,
            ]);
        }
        return true;
    }

}


