<?php

namespace App\Http\Livewire\Sections\WorkOrders;

trait managesLotSourcesModal
{
    public $lotSourcesModal;
    public $woStartData;
    public $lotCards = [
        // 'ingredient' => '$ingredient',
        // 'amount' => '350',
        // 'unit' => $convertedIngredient['unit'],
    ];
    public $selectedSource = [];



    public function start()
    {
        $sources = $this->resolveSelectedSource();

        dd($sources);

        // $workOrder->start() 
        //     ? null
        //     : $this->emit('toast', '', __('sections/workorders.a_work_order_already_in_progress'), 'error');
    }

    private function resolveSelectedSource()
    {
        $result = [];
        foreach($this->selectedSource as $fieldKey => $sources) {
            foreach($sources as $source) {
                [$productId, $lotNumber] = explode(',', $source);
                $result[$fieldKey] = ['product_id' => $productId, 'lot_number' => $lotNumber];
            }
        }
        return $result;
    }


    public function isResourceEnough($index) // !! buradan devam et
    {
        $source = $this->resolveSelectedSource();
        if(array_key_exists($index, $source)) {
            return false;
        }
        return true;

    }

}