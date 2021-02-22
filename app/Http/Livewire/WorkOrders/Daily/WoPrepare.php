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
        // 'amount' => '462',
        // 'unit' => $convertedIngredient['unit'],
    ];


    public function mount($workOrder) // !! bu sayfaya erişim koşulları neler olacak? İki gün sonraki iş emri? geçmiş iş emri?
    {
        $this->workOrder = $workOrder;
        $this->ingredientCards = $this->workOrder->product->recipe->calculateNecessaryIngredients($this->workOrder->wo_amount, $this->workOrder->unit_id);
        // dd($this->ingredientCards[0]['ingredient']->pivot);
    }


    public function emptyIngredientReserveds($index)
    {
        if($this->workOrder->isPreparing() && $this->isRowReady($index)) {
            if($this->workOrder->reservationsFor($this->ingredientCards[$index]['ingredient']['id'])->delete()) {
                $this->emit('toast', '', __('common.context_deleted'), 'info');
                $this->workOrder->activate();
            }
        }
    }

    public function isRowReady($index) : bool
    {
        return $this->workOrder->areSourcesReadyFor($this->ingredientCards[$index]['ingredient']['id']);
    }


    public function markAsCompleted()
    {
        $this->workOrder->setPrepared();
        return redirect()->route('work-orders.daily');
    }

    public function downgradeToPreparing()
    {
        $this->workOrder->setPreparing();
    }

    // public function woStart()
    // {
    //     dd($this->workOrder->setInProgress());
    //     // dd("başladı");
    // }


    public function classes()
    {
        $wo = $this->workOrder;
        if($wo->isApproved()) {
            return [
                'statusIcon' => 'double check icon',
                'statusClass' => 'text-green-500',
                'explanation' => __('workorders.mark_as_ready_when_all_sources_picked'),
            ];
        } elseif($wo->isCompleted()) {
            return [
                'statusIcon' => 'checkmark icon',
                'statusClass' => 'text-green-500',
                'explanation' => __('workorders.mark_as_ready_when_all_sources_picked'),
            ];
        } elseif($wo->isInProgress()) {
            return [
                'statusIcon' => 'loading cog icon',
                'statusClass' => 'text-yellow-500',
                'explanation' => __('workorders.production_started_at_time', ['time' => optional($this->workOrder->startedAt())->diffForHumans()]),
            ];
        } elseif($wo->isPrepared()) {
            return [
                'statusIcon' => 'pause icon',
                'statusClass' => 'text-green-500',
                'explanation' => __('workorders.all_sources_are_prepared_and_wo_can_get_start'),
            ];
        } elseif($wo->isPreparing()) {
            return [
                'statusIcon' => 'loading clock icon',
                'statusClass' => 'text-orange-500',
                'explanation' => __('workorders.mark_as_ready_when_all_sources_picked'),
            ];
        } elseif($wo->isActive()) {
            return [
                'statusIcon' => 'clock icon',
                'statusClass' => 'text-blue-500',
                'explanation' => __('workorders.mark_as_ready_when_all_sources_picked'),
            ];
        } elseif($wo->isSuspended()) {
            return [
                'statusIcon' => 'ban icon',
                'statusClass' => 'text-gray-500',
                'explanation' => __('workorders.mark_as_ready_when_all_sources_picked'),
            ];
        }
    }




    public function render()
    {
        return view('livewire.work-orders.daily.wo-prepare', ['classes' => $this->classes()]);
    }
}
