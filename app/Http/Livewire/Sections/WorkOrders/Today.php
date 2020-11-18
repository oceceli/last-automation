<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Common\Facades\Conversions;
use App\Common\Facades\Stock;
use App\Models\Unit;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Livewire\Component;

class Today extends Component
{

    public $todayDate; // just date of today
    public $workOrders;


    public $unit_id;
    public $totalProduced;
    public $waste = 0; 

    public $selectedUnit;

    public $rules = [
        'unit_id' => 'required|integer|min:1',
        'totalProduced' => 'required|numeric',
        'waste' => 'nullable|numeric',
    ];
    


    public function mount()
    {
        $this->todayDate = Carbon::now()->format('d.m.Y - D');
        $this->workOrders = WorkOrder::getTodaysList();
    }

    public function updatedUnitId($id)
    {
        $this->selectedUnit = Unit::find($id);
    }
    

    public function submitProductionCompleted($id)
    {
        $this->validate();
        $workOrder = $this->workOrders->find($id);
        
        $workOrder->end();

        $baseTotal = Conversions::toBase($this->selectedUnit, $this->totalProduced)['amount'];
        $baseWaste = Conversions::toBase($this->selectedUnit, $this->waste)['amount'];

        if($baseTotal > 0) {
            Stock::moveInProduction($workOrder, $baseTotal);
        } else {
            $this->emit('toast', '', __('sections/workorders.wo_completed_with_zero_production'), 'warning');
        }

        if($baseWaste > 0)
            Stock::moveOutProduction($workOrder, $baseWaste);

    }

    public function startJob($id)
    {
        if( ! WorkOrder::getInProgress()) {
            $workOrder = $this->workOrders->find($id);
            $workOrder->start();
        } else {
            $this->emit('toast', '', __('sections/workorders.a_work_order_already_in_progress'), 'error');
        }
        
    }
    
    public function getInProductionProperty()
    {
        return WorkOrder::getInProgress();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function clearFields()
    {
        $this->reset('totalProduced', 'waste', 'unit_id', 'selectedUnit');
    }

    public function render()
    {
        return view('livewire.sections.workorders.today');
    }
}
