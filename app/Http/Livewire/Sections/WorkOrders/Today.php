<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Common\Facades\Stock;
use App\Models\Unit;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
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
        'unit_id' => 'required|min:1',
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
    

    public function submitProductionCompleted($key)
    {
        $this->validate();
        Stock::test();
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
