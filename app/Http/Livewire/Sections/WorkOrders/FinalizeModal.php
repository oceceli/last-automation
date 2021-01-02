<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Models\Unit;

trait FinalizeModal
{
    public $finalizeModal;
    public $finalizeData;

    public $unit_id;
    public $selectedUnit;
    public $production_total;
    public $production_waste = 0; 
    // public $datetime; // daha sonra forma ekleyebilirim. Üretim bitiş zamanı 'şu an' harici de seçilebilir mi? // bana seçilemez gibi geliyo 

    protected $rules = [
        'unit_id' => 'required|integer|min:1',
        'production_total' => 'required|numeric|gt:production_waste',
        'production_waste' => 'nullable|numeric|lt:production_total',
    ];

    protected $validationAttributes = [
        'unit_id' => 'Birim',
        'production_total' => 'Toplam',
        'production_waste' => 'Fire',
    ];

    

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }



    public function updatedUnitId($id)
    {
        $this->selectedUnit = Unit::find($id);
    }
    


    public function FinalizeProcess($id)
    {
        $this->finalizeModal = true;
        $this->finalizeData = $this->workOrders->find($id);

        // set base unit initially so user will probably select base unit
        $this->unit_id = $this->finalizeData->product->baseUnit->id;
        $this->updatedUnitId($this->unit_id);
    }



    public function ConfirmFinalize()
    {
        $this->validate();

        if($this->finalizeData->saveProductionResults($this->production_total, $this->production_waste, $this->unit_id))
            $this->emit('toast', __('sections/workorders.production_is_completed'), __('sections/workorders.reserved_sources_deducted_from_stocks_and_product_added_to_stock', ['product' => $this->finalizeData->product->name]), 'success');

        $this->reFetchTable();
    }



    
    public function abort($id)
    {
        $workOrder = $this->workOrders->find($id);

        if($workOrder->abort())
            $this->emit('toast', __('sections/workorders.production_aborted'), __('sections/workorders.reserved_sources_released'), 'info');

        $this->closeFinalizeModal();
    }



    public function closeFinalizeModal()
    {
        $this->finalizeModal = false;
        $this->reset('finalizeData', 'unit_id', 'selectedUnit', 'production_total', 'production_waste');
    }



    public function updatedFinalizeModal($value)
    {
        if(!$value) $this->closeFinalizeModal();
    }


}