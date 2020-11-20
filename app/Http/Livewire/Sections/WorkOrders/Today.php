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


    // modal form, it will go to the stockmoves table
    public $unit_id;
    public $totalProduced;
    public $waste = 0; 
    // public $datetime; // daha sonra forma ekleyebilirim. Üretim bitiş zamanı 'şu an' harici de seçilebilir mi?

    public $selectedUnit;

    public $rules = [
        'unit_id' => 'required|integer|min:1',
        'totalProduced' => 'required|numeric',
        'waste' => 'nullable|numeric',
    ];
    

// stok giriş çıkış işlemlerinizi buradan yapabilirsiniz
// Lütfen ekle butonunu kullanın 

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
        $baseTotal = Conversions::toBase($this->selectedUnit, $this->totalProduced)['amount'];
        $baseWaste = Conversions::toBase($this->selectedUnit, $this->waste)['amount'];

        if($baseTotal > 0) {
            if($baseWaste > $baseTotal) 
                return $this->emit('toast', __('common.error.title'), __('stockmoves.waste_cannot_be_greater_than_total_amount'), 'error');

            $workOrder = $this->workOrders->find($id);
            $workOrder->end();
            
            foreach($workOrder->product->recipe->ingredients as $ingredient) {
                $ingreUnitId = $ingredient->pivot->unit_id;
                $ingreAmount = $ingredient->pivot->amount;
    
                $totalDecrease = $baseTotal * Conversions::toBase($ingreUnitId, $ingreAmount)['amount'];
                Stock::decreasedIngredient($workOrder, $ingredient->id, $totalDecrease);
            }

            Stock::productionGross($workOrder, $baseTotal);
            if($baseWaste > 0) 
                Stock::productionWaste($workOrder, $baseWaste);
        } else {
            $this->emit('toast', '', __('sections/workorders.wo_completed_with_zero_production'), 'warning');
        }


    }


    /**
     * Put workorder in progress 
     */
    public function startJob($id)
    {
        if( ! WorkOrder::getInProgress()) { // düzelt burayı !!!
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
