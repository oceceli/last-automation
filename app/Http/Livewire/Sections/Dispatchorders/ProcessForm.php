<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Models\DispatchProduct;
use App\Services\Address\AddressService;
use Livewire\Component;

class ProcessForm extends Component
{

    public $dispatchOrder;
    public $dispatchAddress;

    // model rows
    public $rows;

    public $doLotModal = false;
    public $selectedDispatchProduct;

    protected $listeners = ['refresh' => '$refresh'];
    
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


    public function mount($dispatchOrder)
    {
        $this->dispatchOrder = $dispatchOrder;        
        $this->dispatchAddress = AddressService::concatenated($dispatchOrder->address);
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


    public function siblings($index)
    {
        $rows = $this->rows;
        unset($rows[$index]);
        return $rows;
    }


    /**
     * Open modal for specifying lot sources to dispatch
     */
    public function openDoLotModal($id)
    {
        $this->selectedDispatchProduct = DispatchProduct::find($id);
        // if($this->selectedDispatchProduct->isReady()) {
        //     return "hava";
        // }

        $this->addRow();
        $this->doLotModal = true;
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
     * Gives actual stock amount which depends on lot number
     */
    private function lotMax($lotNumber)
    {
        return $this->selectedDispatchProduct->product->onlyLot($lotNumber); // ?? index geç içine
    }



    // private function lotIsEnough($index) // ?? kullanılmıyor
    // {
    //     return $this->lotMax($this->rows[$index]['lot_number']) >= $this->rows[$index]['reserved_amount'];
    // }


    /**
     * Sum of rows' reserved_amount columns except row itself(index)
     */
    private function siblingsCovered($index)
    {
        return $this->coveredAmount() - $this->rows[$index]['reserved_amount'];
    }



    private function amountOf($index) // ?? kullan bunu
    {
        return $this->rows[$index]['reserved_amount'];
    }



    /**
     * Total covered amount by user
     */
    public function coveredAmount()
    {
        return array_sum(array_column($this->rows, 'reserved_amount'));
    }



    public function necessaryAmount()
    {
        return $this->selectedDispatchProduct->dp_amount - $this->coveredAmount();
    }



    /**
     * Limit addable rows by count of existing lot sources
     */
    public function cannotAddRow()
    {
        return $this->rows && $this->selectedDispatchProduct->product->lotCount() <= count($this->rows);
    }



    public function removeRow($index)
    {
        if($this->cannotRemoveRow()) return;
        unset($this->rows[$index]);
    }




    public function cannotRemoveRow()
    {
        return count($this->rows) === 1;
    }


    public function inputDisabled($index)
    {
        return $this->rows[$index]['lot_number'] == null;
    }



    /**
     * Validates and submits the form
     */
    public function submitLots()
    {
        if(! $this->selectedDispatchProduct) return;
        if($this->cannotSubmit()) return;

        $this->validate();
        
        foreach($this->rows as $row) {
            $this->dispatchOrder->reservedStocks()->create([
                'product_id' => $this->selectedDispatchProduct->product_id,
                'reserved_lot' => $row['lot_number'],
                'reserved_amount' => $row['reserved_amount'],
            ]);
        }

        $this->selectedDispatchProduct->setReady();
        $this->closeDoLotModal();
        $this->refresh();

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


    public function refresh()
    {
        $this->emitSelf('refresh');
    }

    /**
     * Extract rows' indexes, values and call the related function
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



    public function render()
    {
        return view('livewire.sections.dispatchorders.process-form');
    }
}
