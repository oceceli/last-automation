<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Services\Address\AddressService;
use Livewire\Component;

class ProcessForm extends Component
{

    public $dispatchOrder;
    public $dispatchAddress;

    // model cards
    public $cards;


    public function mount($dispatchOrder)
    {
        $this->dispatchOrder = $dispatchOrder;

        foreach($this->dispatchOrder->reservedStocks()->select('id')->get() as $key => $reservationId) {
            $this->addRow($key);
        }
        
        $this->dispatchAddress = AddressService::concatenated($this->dispatchOrder->address);
    }


    /**
     * Add a brand new row into the card
     */
    public function addRow($index)
    {
        $this->cards[$index]['rows'][] = [
            'lot_number' => null,
            'reserved_amount' => null,
        ];
    }

    public function render()
    {
        return view('livewire.sections.dispatchorders.process-form');
    }
}
