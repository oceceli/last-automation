<?php

namespace App\Http\Livewire\WorkOrders;

use App\Http\Livewire\Traits\WorkOrders\FinalizeModal;
use App\Http\Livewire\Traits\WorkOrders\ReservedSourcesModal;
use App\Http\Livewire\Traits\WorkOrders\ReserveSourcesModal;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Livewire\Component;

class Today extends Component
{

    use ReserveSourcesModal;
    use ReservedSourcesModal;
    use FinalizeModal;

    public $todayDate; // just date of today
    public $workOrders;


    protected $listeners = ['new_work_order_created' => 'listenWorkOrderCreated', 'refreshTable' => '$refresh'];


    public function mount()
    {
        $this->todayDate = Carbon::now()->format('d.m.Y - D');
        $this->workOrders = WorkOrder::getTodaysList();
    }

    

    /**
     * Re-fetch the list upon new work order created
     */
    public function listenWorkOrderCreated()
    {
        $this->workOrders = WorkOrder::getTodaysList();
    }


    
    public function getInProgressProperty()
    {
        return WorkOrder::inProgressCurrently();
    }



    private function reFetchTable() // ?? yerini refreshtable'a bırakabilir mi?
    {
        $this->reset('production_total', 'production_waste', 'unit_id', 'selectedUnit', 'finalizeModal');
        $this->workOrders = WorkOrder::getTodaysList();
    }


    
    private function refreshTable()
    {
        $this->emitSelf('refreshTable');
    }



    public function render()
    {
        return view('livewire.work-orders.today');
    }


    
    public function delete($id)
    {
        $workOrder = $this->workOrders->find($id);
        $workOrder->delete();
        $this->refreshTable();
    }
}