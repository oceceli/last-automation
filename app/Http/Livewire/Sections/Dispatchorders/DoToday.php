<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Services\Dispatch\DispatchService;
use Livewire\Component;

class DoToday extends Component
{

    public $dispatchOrders;

    public $approveModal = false;
    public $tobeApprovedDispatchOrder;
    
    public function mount()
    {
        $this->dispatchOrders = DispatchService::getDaily();
    }


    public function approve()
    {
        $this->tobeApprovedDispatchOrder->approve();
    }

    public function deny()
    {
        $this->tobeApprovedDispatchOrder->deny();
    }


    public function openApproveModal($id)
    {
        $this->tobeApprovedDispatchOrder = $this->dispatchOrders->find($id);
        $this->approveModal = true;
    }

    private function closeApproveModal()
    {
        $this->reset('tobeApprovedDispatchOrder', 'approveModal');
    }

    public function updatedApproveModal($bool)
    {
        if(!$bool) $this->closeApproveModal();
    }

    public function render()
    {
        return view('livewire.sections.dispatchorders.do-today');
    }
}
