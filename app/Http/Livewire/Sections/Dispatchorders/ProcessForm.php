<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Models\DispatchProduct;
use App\Services\Address\AddressService;
use Livewire\Component;

class ProcessForm extends Component
{
    use DispatchLotPicker;

    public $dispatchOrder;
    public $dispatchAddress;


    protected $listeners = ['refresh' => '$refresh'];
    
    
    public function mount($dispatchOrder)
    {
        $this->dispatchOrder = $dispatchOrder;        
        $this->dispatchAddress = AddressService::concatenated($dispatchOrder->address);
    }


    public function markAsCompleted()
    {
        $this->dispatchOrder->markAsCompleted();
    }

    
    public function refresh()
    {
        $this->emitSelf('refresh');
    }



    public function render()
    {
        return view('livewire.sections.dispatchorders.process-form');
    }
}
