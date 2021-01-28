<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Models\DispatchProduct;

trait DispatchLotPicker
{
    // model rows
    public $rows;

    public $doLotModal = false;
    public $selectedDispatchProduct;


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
            'rows.*.lot_number' => __('dispatchorders.lot_number'),
            'rows.*.reserved_amount' => __('common.amount'),
        ];
    }




    /**
     * Open modal for specifying lot sources to dispatch
     */
    public function openDoLotModal($id)
    {
        $this->selectedDispatchProduct = DispatchProduct::find($id);
        if($this->isInEditMode()) {
            return $this->setEditMode();
        }

        $this->doLotModal = true;
        $this->addRow();
    }

    


    public function closeDoLotModal()
    {
        $this->reset('rows', 'doLotModal', 'selectedDispatchProduct');
    }


    

    public function updatedDoLotModal($bool)
    {
        if(!$bool) $this->closeDoLotModal();
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
        $inputAmount = $row['reserved_amount'];
        $lotMax = $this->lotMax($row['lot_number']);
        
        if(! $row['lot_number'] || ! $row['reserved_amount'])
            return $this->rows[$index]['reserved_amount'] = null;
        
        $need = $this->selectedDispatchProduct->dp_amount - $this->siblingsCovered($index);

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
     * Extracts rows' indexes, values and calls the related function
     */
    public function updatedRows($value, $location)
    {
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
        if(! $this->selectedDispatchProduct) return;
        if($this->cannotSubmit()) return;

        $this->validate();

        if($this->isInEditMode()) 
            $this->clearDpReserveds();
        
        foreach($this->rows as $row) {
            $this->dispatchOrder->reservedStocks()->create([
                'product_id' => $this->selectedDispatchProduct->product_id,
                'reserved_lot' => $row['lot_number'],
                'reserved_amount' => $row['reserved_amount'],
            ]);
        }

        if(!$this->isInEditMode()) 
            $this->selectedDispatchProduct->setReady();

        $this->closeDoLotModal();
        $this->refresh();

    }





    /************ Edit Mode ********************************************** */
    /********************************************************************* */

    private function setEditMode()
    {
        // just a protection 
        if($this->selectedDpReserveds()->isEmpty()) return; 

        // fill in the rows with incoming data
        foreach($this->selectedDpReserveds() as $reservation) {
            $this->rows[] = [
                'lot_number' => $reservation->reserved_lot,
                'reserved_amount' => $reservation->reserved_amount,
            ];
        }
        $this->doLotModal = true;
    }


    public function isInEditMode()
    {
        return $this->selectedDispatchProduct->isReady();
    }



    public function emptyDpReserveds($id)
    {
        $this->selectedDispatchProduct = DispatchProduct::find($id);
        $this->clearDpReserveds();
        $this->selectedDispatchProduct->undoReady();

        $this->reset('selectedDispatchProduct');
        $this->refresh();
    }


    /************ Logical Helpers ********************************************** */
    /*************************************************************************** */


    private function selectedDpReservedsQuery()
    {
        return $this->dispatchOrder->reservedStocks()
            ->where('product_id', $this->selectedDispatchProduct->product_id);
    }



    private function selectedDpReserveds()
    {
        return $this->selectedDpReservedsQuery()
            ->get();
    }



    private function clearDpReserveds()
    {
        return $this->selectedDpReservedsQuery()->delete();
    }



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
    private function siblingsCovered($index)
    {
        return $this->coveredAmount() - $this->rows[$index]['reserved_amount'];
    }



    /**
     * Gives actual stock amount which depends on lot number
     */
    private function lotMax($lotNumber)
    {
        return $this->selectedDispatchProduct->product->onlyLot($lotNumber); // ?? index geç içine
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
        return $this->selectedDispatchProduct->dp_amount - $this->coveredAmount();
    }


    


    /************ Rules ********************************************** */
    /***************************************************************** */

    /**
     * Limit addable rows by count of existing lot sources
     */
    public function cannotAddRow() : bool
    {
        return $this->rows && $this->selectedDispatchProduct->product->lotCount() <= count($this->rows);
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



    /**
     * Custom validations just before the submit
     */
    public function cannotSubmit() : bool
    {
        // Needs for order must be covered and lots must be different from one another
        return $this->selectedDispatchProduct->dp_amount != $this->coveredAmount()
               || count(array_unique(array_column($this->rows, 'lot_number'))) !== count($this->rows);
    }

}