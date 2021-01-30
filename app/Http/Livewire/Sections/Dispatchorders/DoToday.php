<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Http\Livewire\Refresh;
use App\Services\Dispatch\DispatchService;
use Livewire\Component;

class DoToday extends Component
{
    use Refresh;

    public $dispatchOrders;

    public $approveModal = false;
    public $tobeApprovedDispatchOrder;

    protected $listeners = ['refresh' => '$refresh'];
    
    public function mount()
    {
        $this->dispatchOrders = DispatchService::getDaily();
    }
    

    public function approve()
    {
        $this->tobeApprovedDispatchOrder->approve();
        $this->closeApproveModal();
    }

    
    public function deny()
    {
        $this->tobeApprovedDispatchOrder->deny();
        $this->closeApproveModal();
    }


    public function openApproveModal($id)
    {
        $this->tobeApprovedDispatchOrder = $this->dispatchOrders->find($id);
        $this->approveModal = true;
    }

    private function closeApproveModal()
    {
        $this->reset('tobeApprovedDispatchOrder', 'approveModal');
        $this->refresh();
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
