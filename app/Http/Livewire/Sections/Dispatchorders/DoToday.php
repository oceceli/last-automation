<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Services\Dispatch\DispatchService;
use Livewire\Component;

class DoToday extends Component
{

    public $dispatchOrders;
    
    public function mount()
    {
        $this->dispatchOrders = DispatchService::getDaily();
    }





    public function render()
    {
        return view('livewire.sections.dispatchorders.do-today');
    }
}
