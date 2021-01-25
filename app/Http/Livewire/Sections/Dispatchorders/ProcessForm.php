<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Models\DispatchProduct;
use App\Models\ReservedStock;
use App\Services\Address\AddressService;
use Livewire\Component;

class ProcessForm extends Component
{

    public $dispatchOrder;
    public $dispatchAddress;

    // model cards
    public $cards;

    public $doLotModal = false;
    public $selectedDP;
    public $lotCount;


    public function mount($dispatchOrder)
    {
        $this->dispatchOrder = $dispatchOrder;        
        $this->dispatchAddress = AddressService::concatenated($this->dispatchOrder->address);
    }

    public function openDoLotModal($reservationId)
    {
        $this->reset('cards');
        $this->addCard();
        $this->doLotModal = true;
        $this->selectedDP = DispatchProduct::find($reservationId);
        $this->lotCount = $this->selectedDP->product->lotCount();
    }

    /**
     * Add a brand new row into the card
     */
    public function addCard()
    {
        if($this->cannotAddCard()) return;
        $this->cards[] = [
            'lot_number' => null,
            'reserved_amount' => null,
        ];
    }

    
    public function cannotAddCard()
    {
        return $this->cards && $this->lotCount <= count($this->cards);
    }



    public function removeCard($index)
    {
        if($this->cannotRemoveCard()) return;
        unset($this->cards[$index]);
    }


    public function cannotRemoveCard()
    {
        return count($this->cards) === 1;
    }


    public function coveredAmount()
    {
        return array_sum(array_column($this->cards, 'reserved_amount'));
    }

    public function submitLots()
    {
        $product = $this->selectedDP->product;
        
        if(! $this->selectedDP) return;
        
        $totalInputAmount = array_sum(array_column($this->cards, 'reserved_amount'));

        // is input-amount equals or smaller of actual amount of lot source 
        foreach($this->cards as $card) {
            $lotMax = $product->onlyLot($card['lot_number']);
            if($card['reserved_amount'] > $lotMax)
                $this->emit('toast', '!!Lot yetersiz', '!!!Belirtilen kaynak yeterli miktarı karşılamıkyor', 'warning');
        }


        if($totalInputAmount < $this->selectedDP->dp_amount) 
            dd("eksik");

        
        foreach($this->cards as $card) {
            $this->dispatchOrder->reservedStocks()->create([
                'product_id' => $product,
                'reserved_lot' => $card['lot_number'],
                'reserved_amount' => $card['reserved_amount'],
            ]);
        }

        
        
        

        
        // !! tanımlanan lotlar(cards) sevk emrindeki miktarı karşılasın
        // !! dispatchorder üzerinden reservedstocks oluştur, lotlar ile

    }

    public function render()
    {
        return view('livewire.sections.dispatchorders.process-form');
    }
}
