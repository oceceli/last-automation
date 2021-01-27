<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Models\DispatchProduct;
use App\Services\Address\AddressService;
use Livewire\Component;

class ProcessForm extends Component
{

    public $dispatchOrder;
    public $dispatchAddress;

    // model cards
    public $cards;

    public $doLotModal = false;
    public $dispatchPivot;
    public $lotCount;

    
    protected function rules()
    {
        return [
            'cards.*.lot_number' => 'required',
            'cards.*.reserved_amount' => 'required|numeric',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'cards.*.lot_number' => __('dispatchorders.lot_number'),
            'cards.*.reserved_amount' => __('common.amount'),
        ];
    }


    public function mount($dispatchOrder)
    {
        $this->dispatchOrder = $dispatchOrder;        
        $this->dispatchAddress = AddressService::concatenated($this->dispatchOrder->address);
    }



    /**
     * Add a brand new row into the card
     */
    public function addCard()
    {
        if($this->cannotAddCard()) return;
        $this->cards[] = [
            'lot_number' => null,
            'reserved_amount' => null,
        ];
    }


    public function siblings($index)
    {
        $cards = $this->cards;
        unset($cards[$index]);
        return $cards;
    }


    /**
     * Open modal for specifying lot sources to dispatch
     */
    public function openDoLotModal($id)
    {
        $this->reset('cards');
        $this->addCard();
        $this->doLotModal = true;
        $this->dispatchPivot = DispatchProduct::find($id);
        $this->lotCount = $this->dispatchPivot->product->lotCount();
    }

    

    /**
     * Index stands for cards' index
     */
    public function updatedLotNumber($index, $lotNumber)
    {
        // don't let selected lot numbers same in all cards
        if(in_array($lotNumber, array_column($this->siblings($index), 'lot_number'))) {
            $this->cards[$index]['lot_number'] = null;
            $this->cards[$index]['reserved_amount'] = null;
            return;
        }
        
        $this->updatedReservedAmount($index);
    }




    /**
     * Index stands for cards' index
     */
    public function updatedReservedAmount($index, $value = null)
    {
        $card = $this->cards[$index];
        $inputAmount = $card['reserved_amount'];
        $lotMax = $this->lotMax($card['lot_number']);
        
        if(! $card['lot_number'] || ! $card['reserved_amount'])
            return $this->cards[$index]['reserved_amount'] = null;
        
        $need = $this->dispatchPivot->dp_amount - $this->siblingsCovered($index);

        if($inputAmount <= $lotMax) {
            if($inputAmount >= $need) {
                $this->cards[$index]['reserved_amount'] = $need;
            }
        } else {
            if($need <= $lotMax) {
                $this->cards[$index]['reserved_amount'] = $need;
            } else {
                $this->cards[$index]['reserved_amount'] = $lotMax;
            }
        }

        
    }



    /**
     * Gives actual stock amount which depends on lot number
     */
    private function lotMax($lotNumber)
    {
        return $this->dispatchPivot->product->onlyLot($lotNumber); // ?? index geç içine
    }



    // private function lotIsEnough($index) // ?? kullanılmıyor
    // {
    //     return $this->lotMax($this->cards[$index]['lot_number']) >= $this->cards[$index]['reserved_amount'];
    // }


    /**
     * Sum of cards' reserved_amount columns except card itself(index)
     */
    private function siblingsCovered($index)
    {
        return $this->coveredAmount() - $this->cards[$index]['reserved_amount'];
    }



    private function amountOf($index) // ?? kullan bunu
    {
        return $this->cards[$index]['reserved_amount'];
    }



    /**
     * Total covered amount by user
     */
    public function coveredAmount()
    {
        return array_sum(array_column($this->cards, 'reserved_amount'));
    }



    public function necessaryAmount()
    {
        return $this->dispatchPivot->dp_amount - $this->coveredAmount();
    }




    public function cannotAddCard()
    {
        return $this->cards && $this->lotCount <= count($this->cards);
    }



    public function removeCard($index)
    {
        if($this->cannotRemoveCard()) return;
        unset($this->cards[$index]);
    }




    public function cannotRemoveCard()
    {
        return count($this->cards) === 1;
    }


    public function inputDisabled($index)
    {
        return $this->cards[$index]['lot_number'] === null;
    }



    /**
     * Validates and submits the form
     */
    public function submitLots()
    {
        if(! $this->dispatchPivot) return;
        if($this->cannotSubmit()) return;

        $this->validate();
        
        foreach($this->cards as $card) {
            $this->dispatchOrder->reservedStocks()->create([
                'product_id' => $this->dispatchPivot->product_id,
                'reserved_lot' => $card['lot_number'],
                'reserved_amount' => $card['reserved_amount'],
            ]);
        }

        $this->dispatchPivot->setReady();

    }



    
    public function cannotSubmit() : bool
    {
        return $this->dispatchPivot->dp_amount != $this->coveredAmount()
               || count(array_unique(array_column($this->cards, 'lot_number'))) !== count($this->cards);
    }


    /**
     * Extract cards' indexes, values and call the related function
     */
    public function updatedCards($value, $location)
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
