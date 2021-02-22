<?php

namespace App\Http\Livewire\Traits\WorkOrders;

use App\Common\Facades\Conversions;
use App\Models\Product;
use App\Services\Recipe\ToleranceService;

trait WorkOrderLotPicker
{

    public $woLotPickerModal = false;
    public $rows = [];
    
    public $selectedIngredient;
    public $ingredientPivot;
    public $selectedIndex;

    public $reservationViewModal = false;


    protected function rules()
    {
        return [
            'rows.*.lot_number' => 'required',
            'rows.*.reserved_amount' => 'required|numeric',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'rows.*.lot_number' => __('workorders.lot_number'),
            'rows.*.reserved_amount' => __('common.amount'),
        ];
    }

   

    /**
     * Open modal for specifying lot sources for workorder
     */
    public function openWoLotPickerModal($index) // ?? dp farklı
    {

        if( ! $this->rowsCanBeProcessed()) return;

        $this->reset('rows');

        $this->selectedIngredient = Product::find($this->ingredientCards[$index]['ingredient']['id']);
        $this->ingredientPivot = $this->ingredientCards[$index]['ingredient']['pivot'];
        
        $this->selectedIndex = $index;
        
        if($this->isInEditMode()) {
            return $this->setEditMode();
        }

        $this->woLotPickerModal = true;
        $this->addRow();
    }


    public function closeWoLotPickerModal()
    {
        $this->reset('rows', 'woLotPickerModal', 'selectedIngredient');
    }

    public function updatedWoLotPickerModal($bool)
    {
        if(!$bool) $this->closeWoLotPickerModal();
    }


    public function openReservationViewModal($index)
    {
        $this->selectedIngredient = Product::find($this->ingredientCards[$index]['ingredient']['id']);
        $this->reservationViewModal = true;
    }

    public function updatedReservationViewModal($bool)
    {
        if(!$bool) $this->reset('selectedIngredient');
    }


    /**
     * Add a brand new row into the row
     */
    public function addRow()
    {
        if($this->cannotAddRow()) return;
        $this->rows[] = [
            'lot_number' => null,
            'reserved_amount' => null,
        ];
    }


    /**
     * Removes row of index
     */
    public function removeRow($index)
    {
        if($this->cannotRemoveRow()) return;
        unset($this->rows[$index]);
    }





    /**
     * Index stands for rows' index
     */
    public function updatedLotNumber($index, $lotNumber)
    {
        // don't let selected lot numbers to be same in all rows
        if(in_array($lotNumber, array_column($this->siblings($index), 'lot_number'))) {
            $this->rows[$index]['lot_number'] = null;
            $this->emit('toast', '', __('dispatchorders.this_lot_selected_already'), 'error');
        }
        
        $this->updatedReservedAmount($index);
    }




    /**
     * Index stands for rows' index
     */
    public function updatedReservedAmount($index, $value = null)
    {
        $row = $this->rows[$index];
        $inputAmount = $this->rows[$index]['reserved_amount'] = abs($row['reserved_amount']); // ?? dp farklı önemli
        $lotMax = $this->lotMax($row['lot_number']);

        if(! $row['lot_number'] || ! $row['reserved_amount'])
            return $this->rows[$index]['reserved_amount'] = null;
        
        $need = $this->getToBase() - $this->siblingsCovered($index);

        if($inputAmount <= $lotMax) {
            if($inputAmount >= $need) {
                $this->rows[$index]['reserved_amount'] = $need;
            }
        } else {
            if($need <= $lotMax) {
                $this->rows[$index]['reserved_amount'] = $need;
            } else {
                $this->rows[$index]['reserved_amount'] = $lotMax;
            }
        }

    }



    /**
     * Extracts rows' indexes, values and calls to the related function
     */
    public function updatedRows($value, $location)
    {
        // prepare-inprogress eye ikonuna tıkladığımda bu fonksiyon alakasız bir şekilde tetik alıyor, önüne böyle geçtim..
        if(! $this->woLotPickerModal) return;

        $array = explode('.', $location);
        $index = $array[0];
        $field = $array[1];

        if($field == 'lot_number') {
            return $this->updatedLotNumber($index, $value);
        } else {
            return $this->updatedReservedAmount($index, $value);
        }
    }


    /**
     * Validates and submits the form
     */
    public function submitLots()
    {
        if(! $this->selectedIngredient) return;
        if($this->cannotSubmit()) return;

        $this->validate();

        if($this->isInEditMode()) 
            $this->reservationsOfIngredient()->delete();
        
        foreach($this->rows as $row) {
            $this->workOrder->reservedStocks()->create([
                'product_id' => $this->selectedIngredient->id,
                'reserved_lot' => $row['lot_number'],
                'reserved_amount' => $row['reserved_amount'],
            ]);
        }

        $this->workOrder->setPreparing();

        $this->closeWoLotPickerModal();
    }





    /************ Edit Mode ********************************************** */
    /********************************************************************* */

    private function setEditMode() // ?? dp farklı
    {
        // fill in the rows with incoming data
        foreach($this->reservationsOfIngredient()->get() as $reservation) {
            $this->rows[] = [
                'lot_number' => $reservation->reserved_lot,
                'reserved_amount' => round($reservation->reserved_amount, 6) + 0,
            ];
        }
        $this->woLotPickerModal = true;
    }


    public function isInEditMode()
    {
        return $this->workOrder->areSourcesReadyFor($this->selectedIngredient->id);
    }




    private function reservationsOfIngredient()
    {
        return $this->workOrder->reservationsFor($this->selectedIngredient->id);
    }


    /************ Logical Helpers ********************************************** */
    /*************************************************************************** */






    /**
     * Gives all rows except itself(index)
     */
    public function siblings($index) : array
    {
        $rows = $this->rows;
        unset($rows[$index]);
        return $rows;
    }



    /**
     * Sum of rows' reserved_amount columns except row itself(index)
     */
    private function siblingsCovered($index) // ?? dp farklı
    {
        $array = $this->rows;
        unset($array[$index]);

        return array_sum(array_column($array, 'reserved_amount'));
    }



    /**
     * Gives actual stock amount which depends on lot number
     */
    private function lotMax($lotNumber)
    {
        return $this->selectedIngredient->onlyLot($lotNumber);
    }


    /**
     * Total covered amount by user
     */
    public function coveredAmount()
    {
        return array_sum(array_column($this->rows, 'reserved_amount'));
    }


    /**
     * Representation for user to know how many sources he/she needs
     */
    public function necessaryAmount()
    {
        $amount = $this->getToBase();
        return round($amount - $this->coveredAmount(), 6) + 0;
    }



    public function getToBase() // ?? dp farklı
    {
        $baseAmount = round(Conversions::toBase($this->selectedIngredient->baseUnit, $this->ingredientCards[$this->selectedIndex]['amount'])['amount'], 6);
        return ! $this->ingredientPivot['literal'] ? ToleranceService::withTolerance($this->workOrder->product->recipe, $baseAmount) :  $baseAmount ;
    }



    // rules --------------------------------------------

    /**
     * Limit addable rows by count of existing lot sources
     */
    public function cannotAddRow() : bool
    {
        return $this->rows && $this->selectedIngredient->lotCount() <= count($this->rows);
    }


    /**
     * Limit deletion of rows when it has only one
     */
    public function cannotRemoveRow() : bool
    {
        return count($this->rows) === 1;
    }


    public function inputDisabled($index) : bool
    {
        return $this->rows[$index]['lot_number'] == null;
    }


    private function rowsCanBeProcessed()
    {
        return ($this->workOrder->isPreparing() || $this->workOrder->isActive());
    }


    /**
     * Custom validations just before the submit
     */
    public function cannotSubmit() : bool
    {
        // Needs for order must be covered and lots must be different from one another
        return round($this->getToBase(), 6) !== round($this->coveredAmount(), 6)
               || count(array_unique(array_column($this->rows, 'lot_number'))) !== count($this->rows)
               || ! $this->rowsCanBeProcessed();
            //    || ! $this->selectedIngredient->dispatchOrder->isNotFinalized();
    }

}