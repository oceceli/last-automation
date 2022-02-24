<?php

namespace App\Http\Livewire\WorkOrders;

use App\Http\Livewire\Deletable;
use App\Http\Livewire\Traits\WorkOrders\DetailsModal;
use App\Http\Livewire\Traits\WorkOrders\FinalizeModal;
use App\Http\Livewire\Traits\WorkOrders\ReservedSourcesModal;
use App\Models\WorkOrder;
use App\Services\WorkOrder\WorkOrderService;
use Carbon\Carbon;
use Livewire\Component;

class WoDaily extends Component
{

    use ReservedSourcesModal;
    use FinalizeModal;
    use DetailsModal;
    use Deletable;

    protected $model = WorkOrder::class;

    public $wo_form_modal = false;


    public $todayDate; // just date of today
    public $workOrders;

    public $approvalModal = false;
    public $approvalWorkOrder;
    


    protected $listeners = ['new_work_order_created' => 'listenWorkOrderCreated', 'refreshTable' => '$refresh'];


    public function mount()
    {
        $this->todayDate = Carbon::now()->format('d.m.Y - D');
        $this->workOrders = WorkOrderService::getTodaysList(); // todo: bu liste kullanıcının rolüne göre bazı kısımları gizli olarak gelmeli(suspended)

        // $this->workOrders = WorkOrder::all(); // !! sil burayı
    }

    
    

    /**
     * Re-fetch the list upon new work order created
     */
    public function listenWorkOrderCreated()
    {
        $this->workOrders = WorkOrderService::getTodaysList();
    }

    private function findWo($workOrderId)
    {
        return $this->workOrders->find($workOrderId);
    }
    
    public function getInProgressProperty()
    {
        return WorkOrderService::inProgressCurrently();
    }

    public function openApprovalModal($workOrderId)
    {
        $this->approvalWorkOrder = $this->findWo($workOrderId);
        $this->approvalModal = true;
    }

    private function closeApprovalModal()
    {
        $this->reset('approvalModal', 'approvalWorkOrder');
    }

    public function updatedApprovalModal($bool)
    {
        if($bool == false) $this->closeApprovalModal();
    }



    public function woActivate($workOrderId)
    {
        $this->findWo($workOrderId)->activate();
    }

    public function woSuspend($workOrderId)
    {
        $this->findWo($workOrderId)->suspend();
    }

    public function woStart($workOrderId)
    {
        $this->findWo($workOrderId)->setInProgress();
    }

    public function woApprove($workOrderId)
    {
        $this->findWo($workOrderId)->approve();
        $this->refreshTable();
    }

    public function woDeny($workOrderId)
    {
        $this->findWo($workOrderId)->deny();
        $this->refreshTable();
    }

    public function woAbort($workOrderId)
    {
        $this->findWo($workOrderId)->abort();
        $this->refreshTable();
    }


    public function routePreparePage($workOrderId)
    {
        return redirect()->route('work-orders.prepare', ['workOrder' => $workOrderId]);
    }

    
    private function refreshTable()
    {
        $this->reset('production_total', 'production_waste', 'unit_id', 'selectedUnit', 'finalizeModal');
        $this->closeApprovalModal();
        $this->emitSelf('refreshTable');
    }


    public function openWoFormModal()
    {
        $this->wo_form_modal = true;
    }

    public function render()
    {
        return view('livewire.work-orders.wo-daily');
    }


    
    // public function delete($id)
    // {
    //     $workOrder = $this->workOrders->find($id);
    //     $workOrder->delete();
    //     $this->refreshTable();
    // }
}
