<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Common\Facades\Conversions;
use App\Common\Facades\Production;
use App\Common\Facades\Stock;
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


    // modal form, it will go to the stockmoves table
    public $unit_id;
    public $production_gross;
    public $production_waste = 0; 
    // public $datetime; // daha sonra forma ekleyebilirim. Üretim bitiş zamanı 'şu an' harici de seçilebilir mi?

    public $selectedUnit;

    public $rules = [
        'unit_id' => 'required|integer|min:1',
        'production_gross' => 'required|numeric|gt:production_waste',
        'production_waste' => 'nullable|numeric|lt:production_gross',
    ];
    

// stok giriş çıkış işlemlerinizi buradan yapabilirsiniz
// Lütfen ekle butonunu kullanın 

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

        // if($this->production_waste > $this->production_gross)
        //     return $this->emit('toast', __('common.error.title'), __('stockmoves.waste_cannot_be_greater_than_total_amount'), 'error');

        $workOrder->saveProductionResults($this->production_gross, $this->production_waste, $this->unit_id);




        // $this->emit('toast', '', __('sections/workorders.wo_completed_with_zero_production'), 'warning');
        

        $this->clearFields();
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

    public function clearFields()
    {
        $this->reset('production_gross', 'production_waste', 'unit_id', 'selectedUnit', 'woCompleteModal');
    }

    public function render()
    {
        return view('livewire.sections.workorders.today');
    }
}
