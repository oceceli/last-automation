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


    public function emptyIngredientReserveds($index)
    {
        if($this->workOrder->reservationsFor($this->ingredientCards[$index]['ingredient']['id'])->delete()) {
            $this->emit('toast', '', __('common.context_deleted'), 'info');
            $this->workOrder->activate();
        }
    }


    public function markAsCompleted()
    {
        $this->workOrder->setPrepared();
    }

    public function downgradeToPreparing()
    {
        $this->workOrder->setPreparing();
    }




    public function render()
    {
        return view('livewire.work-orders.daily.wo-prepare');
    }
}
