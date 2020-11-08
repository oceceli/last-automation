<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Models\WorkOrder;
use Carbon\Carbon;
use Livewire\Component;

class Today extends Component
{

    public $today;
    public $todaysList;


    public function mount()
    {
        $this->today = Carbon::now()->format('d.m.Y');
        $this->todaysList = WorkOrder::getTodaysList();
    }

    public function render()
    {
        return view('livewire.sections.workorders.today');
    }
}
