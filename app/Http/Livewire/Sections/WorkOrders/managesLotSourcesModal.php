<?php

namespace App\Http\Livewire\Sections\WorkOrders;


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
     * Represents lot source cards in the modal (Necessary Ingredients)
     */
    public $lotCards = [
        // 'ingredient' => '$ingredient',
        // 'amount' => '5500',
        // 'unit' => $convertedIngredient['unit'],
    ];

    /**
     * model property
     */
    public $inputModels = [];



    /**
     * Sources selected and confirmed by user ...
     */
    public function start()
    {
        // dd($this->inputModels);
        if(! $resolvedInputModels = $this->validateInputs()) return; 
        // $resolvedInputModels = $this->resolveInputModels();

        if(! $this->woStartData->start())
            return $this->emit('toast', '', __('sections/workorders.a_work_order_already_in_progress'), 'error');


        foreach($resolvedInputModels as $highIndex => $inputs) {

            $productId = $this->lotCards[$highIndex]['ingredient']['id'];
            $necessaryAmount = $this->totalNecessaryAmount($highIndex);

            foreach($inputs as $input) {

                if($necessaryAmount === 0) continue;

                if($necessaryAmount >= $input['available_amount']) {
                    $usedSource = $input['available_amount'];
                    $necessaryAmount -= $input['available_amount'];
                } else {
                    $usedSource = $necessaryAmount;
                    $necessaryAmount = 0;
                }

                $toBeReserved = [
                    'product_id' => $productId, 
                    'reserved_lot' => $input['lot_number'],
                    'reserved_amount' => $usedSource,
                ];

                $this->woStartData->reservedStocks()->create($toBeReserved);
            }
        }

        $this->refreshTable();
        $this->closeModal();

        return $this->emit('toast', '!!! başarılı', '!!! Kaynak tercihleri sorunsuzca kaydedildi', 'success');
    }
    


    private function validateInputs()
    {
        $resolvedInputModels = $this->resolveInputModels();

        // are arrays have equal elements? If not abort
        if(count($this->lotCards) !== count($resolvedInputModels)) {
            return $this->toastNotEnough(); 
        }
        
        foreach($resolvedInputModels as $highIndex => $sources) { // ?? daha kısa bir yolu vardır
            if(! $this->isResourcesEnough($highIndex)) {
                return $this->toastNotEnough(); 
            }
        }

        return $resolvedInputModels;
    }



    
    public function displayCoveredAmount($highIndex)
    {
        $inputModels = $this->resolveInputModels();
        
        if(array_key_exists($highIndex, $inputModels)) {
            $unitName = $this->lotCards[$highIndex]['unit']['name'];
            return $this->isResourcesEnough($highIndex)
                ? ['text' => 'Belirtilen kaynaklar üretimi karşılar düzeyde', 'class' => 'text-green-600']
                : ['text' => floor($this->totalNecessaryAmount($highIndex) - $this->totalCovered($highIndex)) . " " . $unitName . " daha gerekli", 'class' => 'text-red-600'];

        }
        return ['text' => 'Lütfen üretim için kaynak seçin', 'class' => 'text-ease-red'];
    }




    public function isResourcesExcess($index)
    {
        
    }




    private function isResourcesEnough($index) : bool
    {        
        return $this->totalCovered($index) >= $this->totalNecessaryAmount($index);
    }
    


    /**
     * The amount of user provided ingredient sources
     */
    private function totalCovered($highIndex)
    {
        return array_sum(array_column($this->resolveInputModels()[$highIndex], 'available_amount'));
    }


    
    /**
     * How many ingredient needed for production
     */
    private function totalNecessaryAmount($highIndex)
    {
        return $this->lotCards[$highIndex]['amount'];
    }



    private function resolveInputModels()
    {
        $result = [];
        foreach($this->inputModels as $index => $sources) {
            foreach($sources as $source) {
                [$lotNumber, $amount] = explode(',', $source);
                $result[$index][] = [
                    'lot_number' => $lotNumber, 
                    'available_amount' => $amount,
                ];
            }
        }
        return $result;
    }


    /**
     * Empty inputModels whenever modal closed
     */
    public function updatedLotSourcesModal($value)
    {
        if($value === false) {
            $this->reset('inputModels');
        }
    }



    private function closeModal()
    {
        $this->lotSourcesModal = false;
        $this->reset('inputModels');
    }



    private function toastNotEnough()
    {
        $this->emit('toast', '!!! yetersiz', 'kaynaklar yetersiz görünüyor', 'warning');
        return false;
    }

    /**
     * For example; 'lot_5' will become '5'
     */
    // private function indexSync($string)
    // {
    //     return substr($string, strpos($string, '_') + 1);
    // }

}