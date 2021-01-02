<?php

namespace App\Http\Livewire\Sections\WorkOrders;


trait ReserveSourcesModal
{
    /**
     * Modal status
     */
    public $reserveSourcesModal;


    /**
     * Workorder instance which is processing in the moment
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
     * When pressed the start button for a work order, open lotSourceModal to ask which sources to be used
     */
    public function startProcess($id)
    {
        $this->woStartData = $this->workOrders->find($id);
        $this->lotCards = $this->woStartData->product->recipe->calculateNecessaryIngredients($this->woStartData->amount, $this->woStartData->unit_id);
        
        $this->reserveSourcesModal = true;
    }



    /**
     * Sources selected and confirmed by user ...
     */
    public function confirmStart()
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
                    $usedSourceAmount = $input['available_amount'];
                    $necessaryAmount -= $input['available_amount'];
                } else {
                    $usedSourceAmount = $necessaryAmount;
                    $necessaryAmount = 0;
                }

                // don't reserve zero sources
                if($usedSourceAmount == 0) continue;

                $toBeReserved = [
                    'product_id' => $productId, 
                    'reserved_lot' => $input['lot_number'],
                    'reserved_amount' => $usedSourceAmount,
                ];

                $this->woStartData->reservedStocks()->create($toBeReserved);
            }
        }

        $this->refreshTable();
        $this->closeReserveSourcesModal();

        return $this->emit('toast', __('sections/workorders.production_started'), __('sections/workorders.specified_resources_reserved_to_use_in_production'), 'success');
    }
    


    private function validateInputs()
    {
        $resolvedInputModels = $this->resolveInputModels();

        // are both arrays have equal elements?
        if(count($this->lotCards) !== count($resolvedInputModels)) {
            $this->emit('toast', __('common.there_are_missing_fields'), __('sections/workorders.please_specify_all_necessary_sources_for_production'), 'error');
            return false;
        }
        
        // are provided sources enough for production?
        foreach($resolvedInputModels as $highIndex => $sources) {
            if(! $this->isResourcesEnough($highIndex)) {
                $this->emit('toast', __('sections/workorders.insufficient_sources'), __('sections/workorders.please_reserve_enough_amount_of_sources_in_order_to_continue_production'), 'warning');
                return false;
            }
        }

        return $resolvedInputModels;
    }



    /**
     * User will know how many more needed for production instantly
     */
    public function displayCoveredAmount($highIndex)
    {
        $inputModels = $this->resolveInputModels();
        
        if(array_key_exists($highIndex, $inputModels)) {
            $unitName = $this->lotCards[$highIndex]['unit']['name'];
            return $this->isResourcesEnough($highIndex)
                ? ['text' => __('sections/workorders.specified_sources_are_enough_for_manufacturing'), 'class' => 'text-green-600']
                : ['text' => __('sections/workorders.amount_more_required', ['amount' => number_format($this->totalNecessaryAmount($highIndex) - $this->totalCovered($highIndex), 2, ',', '') . " " . strtolower($unitName)]), 'class' => 'text-red-600'];
            
        }
        return ['text' => __('common.not_specified'), 'class' => 'text-ease-red'];
    }




    /**
     * Is sources that specified by user is enough for production?
     */
    private function isResourcesEnough($highIndex) : bool
    {        
        return $this->totalCovered($highIndex) >= $this->totalNecessaryAmount($highIndex);
    }
    


    /**
     * The amount of user provided ingredient sources
     */
    private function totalCovered($highIndex)
    {
        return array_sum(array_column($this->resolveInputModels()[$highIndex], 'available_amount'));
    }


    
    /**
     * How many ingredient needed for production?
     */
    private function totalNecessaryAmount($highIndex)
    {
        return $this->lotCards[$highIndex]['amount'];
    }



    /**
     * Multiselect gives us strings, so need to explode and name them
     */
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
    public function updatedReserveSourcesModal($value)
    {
        if(!$value) $this->closeReserveSourcesModal();
    }



    private function closeReserveSourcesModal()
    {
        $this->reserveSourcesModal = false;
        $this->reset('inputModels', 'woStartData');
    }


}