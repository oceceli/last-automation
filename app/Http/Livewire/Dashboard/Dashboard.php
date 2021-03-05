<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Livewire\Traits\Dashboard\MinThreshold;
use App\Http\Livewire\Traits\Dashboard\Overview;
use App\Models\WorkOrder;
use Livewire\Component;

class Dashboard extends Component
{
    use Overview;
    use MinThreshold;

    

    public function render()
    {
        return view('livewire.dashboard.dashboard');
    }
}
