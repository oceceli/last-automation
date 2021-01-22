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

    public function render()
    {
        return view('livewire.sections.dispatchorders.process-form');
    }
}
