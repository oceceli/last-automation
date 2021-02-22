<?php

namespace App\Http\Livewire\Traits\WorkOrders;

use App\Models\Unit;
use App\Services\WorkOrder\WorkOrderCompleteService;

trait FinalizeModal
{
    public $finalizeModal;
    public $finalizeWorkOrder;

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
    

    
    /**
     * Start workorder finalize process, open modal
     */
    public function finalizeProcess($id)
    {
        $this->finalizeModal = true;
        $this->finalizeWorkOrder = $this->workOrders->find($id);

        // set base unit initially so user will probably select base unit
        $this->unit_id = $this->finalizeWorkOrder->product->baseUnit->id;
        $this->updatedUnitId($this->unit_id);
    }



    /**
     * User filled in inputs and confirmed results
     */
    public function woComplete()
    {
        $this->validate();

        $completeService = new WorkOrderCompleteService($this->finalizeWorkOrder, $this->unit_id, $this->production_total, $this->production_waste);
        if( $completeService->efficiencyIsNotAcceptable()) 
            return $this->emit('toast', 'workorders.efficiency_limits_exceeded', __('workorders.efficiency_limits_exceeded_for_this_production', ['efficiency' => $this->finalizeWorkOrder->product->recipe->tolerance_factor]), 'error');

        if($this->finalizeWorkOrder->complete($completeService))
            $this->emit('toast', __('workorders.production_is_completed'), __('workorders.reserved_sources_deducted_from_stocks_and_product_added_to_stock', ['product' => $this->finalizeWorkOrder->product->prd_name]), 'success');

        $this->refreshTable();
    }



    public function closeFinalizeModal()
    {
        $this->finalizeModal = false;
        $this->reset('finalizeWorkOrder', 'unit_id', 'selectedUnit', 'production_total', 'production_waste');
    }



    public function updatedFinalizeModal($bool)
    {
        if(!$bool) $this->closeFinalizeModal();
    }


}