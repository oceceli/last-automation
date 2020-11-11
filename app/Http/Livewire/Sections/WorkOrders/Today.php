<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Models\WorkOrder;
use Carbon\Carbon;
use Livewire\Component;

class Today extends Component
{

    public $todayDate; // just date of today
    public $todaysList;
    

    public $totalProduced;
    public $waste; 


    public function mount()
    {
        $this->todayDate = Carbon::now()->format('d.m.Y - D');
        $this->todaysList = WorkOrder::getTodaysList();
    }

    public function submitProductionCompleted()
    {
        
    }

    public function clearFields()
    {
        $this->reset('totalProduced', 'waste');
    }

    public function render()
    {
        return view('livewire.sections.workorders.today');
    }
}
