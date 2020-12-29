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
        if(! $resolvedInputModels = $this->validateInputs()) return; 
        // $resolvedInputModels = $this->resolveInputModels();

        if(! $this->woStartData->start())
            return $this->emit('toast', '', __('sections/workorders.a_work_order_already_in_progress'), 'error');


        foreach($resolvedInputModels as $highIndex => $sources) {
            $productId = $this->lotCards[$highIndex]['ingredient']['id'];
            foreach($sources as $source) {
                $this->woStartData->reservedStocks()->create(['product_id' => $productId, 'reserved_lot' => $source['lot_number']]);
            }
        }

        $this->refreshTable();
        $this->closeModal();
        return $this->emit('toast', 'başarılı', 'Kaynak tercihleri sorunsuzca kaydedildi', 'success');
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
                : ['text' => floor($this->necessaryAmount($highIndex) - $this->totalCovered($highIndex)) . " " . $unitName . " daha gerekli", 'class' => 'text-red-600'];

        }
        return ['text' => 'Lütfen üretim için kaynak seçin', 'class' => 'text-ease-red'];
    }


    private function isResourcesEnough($index) : bool
    {        
        return $this->totalCovered($index) >= $this->necessaryAmount($index);
    }
    
    /**
     * The amount of user provided ingredient sources
     */
    private function totalCovered($highIndex)
    {
        return array_sum(array_column($this->resolveInputModels()[$highIndex], 'amount'));
    }
    
    /**
     * How many ingredient needed for production
     */
    private function necessaryAmount($highIndex)
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
                    // 'product_id' => $productId, 
                    'lot_number' => $lotNumber, 
                    'amount' => $amount,
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