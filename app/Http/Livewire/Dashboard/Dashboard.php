<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Livewire\Traits\Dashboard\LiveDispatchOrderReports;
use App\Http\Livewire\Traits\Dashboard\LiveWorkOrderReports;
use App\Http\Livewire\Traits\Dashboard\MinThreshold;
use App\Http\Livewire\Traits\Dashboard\Overview;
use App\Models\WorkOrder;
use Livewire\Component;

class Dashboard extends Component
{
    use Overview;
    use MinThreshold;
    use LiveWorkOrderReports;
    use LiveDispatchOrderReports;

    public $woDetailsModal = false;
    public $modalSelectedWorkOrder;

    
    public function openWoDetailsModal($workOrderId)
    {
        $this->woDetailsModal = true;
        $this->modalSelectedWorkOrder = WorkOrder::find($workOrderId);
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard');
    }
}
