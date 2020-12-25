<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Models\Unit;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Livewire\Component;

class Today extends Component
{

    public $todayDate; // just date of today
    public $workOrders;

    public $woCompleteModal;
    public $woCompleteData;

    // public $newWorkOrderModal = false; 


    // modal form, it will go to the stockmoves table
    public $unit_id;
    public $production_gross;
    public $production_waste = 0; 
    // public $datetime; // daha sonra forma ekleyebilirim. Üretim bitiş zamanı 'şu an' harici de seçilebilir mi?

    public $selectedUnit;

    protected $rules = [
        'unit_id' => 'required|integer|min:1',
        'production_gross' => 'required|numeric|gt:production_waste',
        'production_waste' => 'nullable|numeric|lt:production_gross',
    ];
    
    protected $listeners = ['new_work_order_created' => 'workOrderCreated'];


    public function mount()
    {
        $this->todayDate = Carbon::now()->format('d.m.Y - D');
        $this->workOrders = WorkOrder::getTodaysList();
    }



    public function woCompleteRequest($id)
    {
        $this->woCompleteModal = true;
        $this->woCompleteData = $this->workOrders->find($id);
    }



    public function updatedUnitId($id)
    {
        $this->selectedUnit = Unit::find($id);
    }
    


    public function submitWoCompleted()
    {
        $this->validate();

        $workOrder = $this->woCompleteData;

        if($workOrder->saveProductionResults($this->production_gross, $this->production_waste, $this->unit_id))
            $this->emit('toast', '', __('sections/workorders.production_is_completed'), 'success');

        $this->refreshTable();
    }
    


    public function abort($id)
    {
        $workOrder = $this->workOrders->find($id);
        $workOrder->abort();

        $this->woCompleteModal = false;
    }



    /**
     * Re-fetch the list upon new work order created
     */
    public function workOrderCreated()
    {
        $this->workOrders = WorkOrder::getTodaysList();
        // $this->newWorkOrderModal = false;
    }



    /**
     * Set workorder as in progress 
     */
    public function startJob($id)
    {
        $workOrder = $this->workOrders->find($id);
        $workOrder->start() 
            ? null
            : $this->emit('toast', '', __('sections/workorders.a_work_order_already_in_progress'), 'error');
        
    }


    
    public function getInProgressProperty()
    {
        return WorkOrder::inProgressCurrently();
    }



    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function refreshTable()
    {
        $this->reset('production_gross', 'production_waste', 'unit_id', 'selectedUnit', 'woCompleteModal');
        $this->workOrders = WorkOrder::getTodaysList();
    }



    public function render()
    {
        return view('livewire.sections.workorders.today');
    }


    
    public function delete($id)
    {
        $workOrder = $this->workOrders->find($id);
        $workOrder->delete();
        $this->refreshTable();
    }
}
