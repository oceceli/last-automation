<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Models\Product;

trait managesLotSourcesModal
{
    /**
     * Modal status
     */
    public $lotSourcesModal;

    /**
     * Workorder instance that processing in the moment
     */
    public $woStartData;


    /**
     * Represents lot source cards in the modal.
     */
    public $lotCards = [
        // 'ingredient' => '$ingredient',
        // 'amount' => '5500',
        // 'unit' => $convertedIngredient['unit'],
    ];


    public $userInputLotSource = [];




    public function start()
    {
        $sources = $this->resolveUserInputLotSource();

        dd($sources);

        // $workOrder->start() 
        //     ? null
        //     : $this->emit('toast', '', __('sections/workorders.a_work_order_already_in_progress'), 'error');
    }


    private function resolveUserInputLotSource()
    {
        $result = [];
        foreach($this->userInputLotSource as $fieldKey => $sources) {
            foreach($sources as $source) {
                [$productId, $lotNumber, $amount, $necessaryAmount, $unitName] = explode(',', $source);
                $result[$fieldKey][] = [
                    'product_id' => $productId, 
                    'lot_number' => $lotNumber, 
                    'amount' => $amount, 
                    'necessary_amount' => $necessaryAmount,
                    'unit_name' => $unitName,
                ];
            }
        }
        return $result;
    }


    public function isResourceEnough($index)
    {
        $userInputs = $this->resolveUserInputLotSource();
        $necessaryAmount = // !! buradan devam et, bunları üstten çek

        if(array_key_exists($index, $userInputs)) {
            $totalCovered = array_sum(array_column($userInputs[$index], 'amount'));
            // $necessaryAmount = $userInputs[$index][0]['necessary_amount'];
            // $unitName = $userInputs[$index][0]['unit_name'];
            $necessaryAmount = 0;
            dd($index);

            return $totalCovered < $necessaryAmount
                ? ['text' => floor($necessaryAmount - $totalCovered) . " " . $unitName . " daha gerekli", 'class' => 'text-ease-red']
                : ['text' => 'Belirtilen kaynaklar üretimi karşılar düzeyde', 'class' => 'text-ease-green'];

        }
        return ['text' => 'Lot seçin', 'class' => 'text-ease-red'];
    }

    /**
     * For example; 'lot_5' becomes '5'
     */
    private function extractIndex($subject)
    {
        return substr($subject, 4);
    }

}