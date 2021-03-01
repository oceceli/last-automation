<?php

namespace App\Http\Livewire\DispatchOrders\Daily;

use App\Http\Livewire\Refresh;
use App\Services\Dispatch\DispatchService;
use Livewire\Component;

class DoDaily extends Component
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


    public function redirectPrepare($dispatchOrderId)
    {
        return redirect()->route('dispatchorders.prepare', ['dispatchOrder' => $dispatchOrderId]);
    }

    public function render()
    {
        return view('livewire.dispatch-orders.daily.do-daily');
    }
}
