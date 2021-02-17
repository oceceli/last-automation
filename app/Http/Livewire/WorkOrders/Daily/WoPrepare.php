<?php

namespace App\Http\Livewire\WorkOrders\Daily;

use App\Http\Livewire\Traits\WorkOrders\WorkOrderLotPicker;
use App\Models\Product;
use App\Models\WorkOrder;
use Livewire\Component;

class WoPrepare extends Component
{
    use WorkOrderLotPicker;

    public $workOrder;


    public $ingredientCards = [
        // 'ingredient' => '$ingredient',
        // 'amount' => '5500',
        // 'unit' => $convertedIngredient['unit'],
    ];


    public function mount($workOrder)
    {
        $this->workOrder = $workOrder;
        $this->ingredientCards = $this->workOrder->product->recipe->calculateNecessaryIngredients($this->workOrder->wo_amount, $this->workOrder->unit_id);
    }






    public function render()
    {
        return view('livewire.work-orders.daily.wo-prepare');
    }
}
