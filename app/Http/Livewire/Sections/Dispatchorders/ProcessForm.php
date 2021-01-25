<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

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
    public $selectedReservation;


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
        $this->selectedReservation = ReservedStock::find($reservationId);
    }

    /**
     * Add a brand new row into the card
     */
    public function addCard()
    {
        $this->cards[] = [
            'lot_number' => null,
            'reserved_amount' => null,
        ];
    }

    public function removeCard($index)
    {
        unset($this->cards[$index]);
    }

    public function submitLots()
    {
        $product = $this->selectedReservation->product;
        
        if(! $this->selectedReservation) return;
        // dd($this->dispatchOrder->reservedStocks->toArray());
        
        $totalInputAmount = array_sum(array_column($this->cards, 'reserved_amount'));

        // is input-amount equals or smaller of actual amount of lot source 
        foreach($this->cards as $card) {
            $lotMax = $product->onlyLot($card['lot_number']);
            if($card['reserved_amount'] > $lotMax)
                $this->emit('toast', '!!Lot yetersiz', '!!!Belirtilen kaynak yeterli miktarı karşılamıkyor', 'warning');
        }

        $dispatchReservedAmount = $this->selectedReservation->reserved_amount;

        if($totalInputAmount < $dispatchReservedAmount) 
            dd("eksik");

        
        // foreach($this->cards as $card) {
        //     $this->dispatchOrder->reservedStocks()->create([
        //         'product_id' => $product,
        //         'reserved_lot' => $card['lot_number'],
        //         'reserved_amount' => $card['reserved_amount'],
        //     ]);
        // }

        $oldReserved = $this->dispatchOrder->reservedStocks()
            ->where(['reserved_lot' => null, 'product_id' => $product->id])
            ->first();

        // $oldReserved->delete();
        
        

        
        // !! tanımlanan lotlar(cards) sevk emrindeki miktarı karşılasın
        // !! dispatchorder üzerinden reservedstocks oluştur, lotlar ile
        // !! sevk emrinde oluşturulan reservestocku sil
    }

    public function render()
    {
        return view('livewire.sections.dispatchorders.process-form');
    }
}
