<?php

namespace App\Http\Livewire\WorkOrders;

use App\Http\Livewire\Deletable;
use App\Http\Livewire\Traits\WorkOrders\DetailsModal;
use App\Http\Livewire\Traits\WorkOrders\FinalizeModal;
use App\Http\Livewire\Traits\WorkOrders\ReservedSourcesModal;
use App\Http\Livewire\Traits\WorkOrders\ReserveSourcesModal;
use App\Models\WorkOrder;
use App\Services\WorkOrder\WorkOrderService;
use Carbon\Carbon;
use Livewire\Component;

class WoDaily extends Component
{

    use ReserveSourcesModal;
    use ReservedSourcesModal;
    use FinalizeModal;
    use DetailsModal;
    use Deletable;

    protected $model = WorkOrder::class;


    public $todayDate; // just date of today
    public $workOrders;


    


    protected $listeners = ['new_work_order_created' => 'listenWorkOrderCreated', 'refreshTable' => '$refresh'];


    public function mount()
    {
        $this->todayDate = Carbon::now()->format('d.m.Y - D');
        $this->workOrders = WorkOrderService::getTodaysList(); // todo: bu liste kullanıcının rolüne göre bazı kısımları gizli olarak gelmeli(suspended)

        $this->workOrders = WorkOrder::all(); // !! sil burayı
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
    }

    public function woAbort($workOrderId)
    {
        $this->findWo($workOrderId)->abort();
    }


    public function routePreparePage($workOrderId)
    {
        return redirect()->route('work-orders.prepare', ['workOrder' => $workOrderId]);
    }



    private function reFetchTable() // ?? yerini refreshtable'a bırakabilir mi?
    {
        $this->reset('production_total', 'production_waste', 'unit_id', 'selectedUnit', 'finalizeModal');
        $this->workOrders = WorkOrderService::getTodaysList();
    }


    
    private function refreshTable()
    {
        $this->emitSelf('refreshTable');
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
