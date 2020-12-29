<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Models\Unit;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Livewire\Component;

class Today extends Component
{

    use managesLotSourcesModal;

    public $todayDate; // just date of today
    public $workOrders;

    public $woFinalizeModal;
    public $woFinalizeData;


    

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
    
    protected $listeners = ['new_work_order_created' => 'workOrderCreated', 'refreshTable' => '$refresh'];


    public function mount()
    {
        $this->todayDate = Carbon::now()->format('d.m.Y - D');
        $this->workOrders = WorkOrder::getTodaysList();
    }



    public function woCompleteRequest($id)
    {
        $this->woFinalizeModal = true;
        $this->woFinalizeData = $this->workOrders->find($id);
    }



    public function updatedUnitId($id)
    {
        $this->selectedUnit = Unit::find($id);
    }



    public function submitWoFinalized()
    {
        $this->validate();

        $workOrder = $this->woFinalizeData;

        if($workOrder->saveProductionResults($this->production_gross, $this->production_waste, $this->unit_id))
            $this->emit('toast', '', __('sections/workorders.production_is_completed'), 'success');

        $this->reFetchTable();
    }
    


    public function abort($id)
    {
        $workOrder = $this->workOrders->find($id);
        $workOrder->abort();

        $this->woFinalizeModal = false;
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
     * When pressed the start button for a work order, open lotSourceModal to ask which sources to be used
     */
    public function startThread($id)
    {
        $this->woStartData = $this->workOrders->find($id);
        $this->lotCards = $this->woStartData->product->recipe->calculateNecessaryIngredients($this->woStartData->amount, $this->woStartData->unit_id);
        
        $this->lotSourcesModal = true;
    }




    
    public function getInProgressProperty()
    {
        return WorkOrder::inProgressCurrently();
    }



    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    private function reFetchTable() // ?? yerini refreshtable'a bırakabilir mi?
    {
        $this->reset('production_gross', 'production_waste', 'unit_id', 'selectedUnit', 'woFinalizeModal');
        $this->workOrders = WorkOrder::getTodaysList();
    }


    private function refreshTable()
    {
        $this->emitSelf('refreshTable');
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
