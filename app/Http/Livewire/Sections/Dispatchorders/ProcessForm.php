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
    public function updatedLotNumber($index, $value)
    {
        $this->updatedReservedAmount($index, $value);
    }



    /**
     * Index stands for cards' index
     */
    // public function updatedReservedAmount($index, $value)
    // {
    //     $card = $this->cards[$index];
    //     $lotMax = $this->lotMax($card['lot_number']);

    //     if(! $card['lot_number']) 
    //         return $this->cards[$index]['reserved_amount'] = 0;

    //     if($this->coveredAmount() > $this->dispatchPivot->dp_amount) {
            // if($this->dispatchPivot->dp_amount > $lotMax) 
            //     $this->cards[$index]['reserved_amount'] = $lotMax;
            // else 
            //     $this->cards[$index]['reserved_amount'] = $this->dispatchPivot->dp_amount - $this->siblingsTotalAmount($index);

    //         $this->cards[$index]['reserved_amount'] = $this->dispatchPivot->dp_amount > $lotMax
    //             ? $lotMax
    //             : $this->dispatchPivot->dp_amount - $this->siblingsTotalAmount($index);

    //     } elseif($card['reserved_amount'] > $lotMax) {
    //         $this->cards[$index]['reserved_amount'] = $lotMax;
    //     }
    // }



    /**
     * Index stands for cards' index
     */
    public function updatedReservedAmount($index, $value)
    {
        $card = $this->cards[$index];
        $inputAmount = $card['reserved_amount'];
        $lotMax = $this->lotMax($card['lot_number']);

        if(! $card['lot_number']) 
            return $this->cards[$index]['reserved_amount'] = null;

        // if($inputAmount <= $lotMax) {
            if(($this->dispatchPivot->dp_amount - $this->siblingsCovered($index)) <= $inputAmount) {
                if($inputAmount <= $lotMax) {
                    $this->cards[$index]['reserved_amount'] = ($this->dispatchPivot->dp_amount - $this->siblingsCovered($index));
                } else {
                    $this->cards[$index]['reserved_amount'] = 1; // ????? devam et
                }
            }
        // }
        
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



    /**
     * Submits the form
     */
    public function submitLots()
    {
        if(! $this->dispatchPivot) return;
        if($this->cannotSubmit()) return;
        
        $coveredAmount = $this->coveredAmount();

        // is input-amount equals or smaller of actual amount of lot source
        foreach($this->cards as $card) {
            $lotMax = $this->lotMax($card['lot_number']);
            if($card['reserved_amount'] > $lotMax)
                return $this->emit('toast', '!!Lot yetersiz', '!!!Belirtilen kaynak yeterli miktarı karşılamıyor', 'warning');
        }


        if($coveredAmount < $this->dispatchPivot->dp_amount) 
            dd("eksik");

        
        foreach($this->cards as $card) {
            $this->dispatchOrder->reservedStocks()->create([
                'product_id' => $this->dispatchPivot->product,
                'reserved_lot' => $card['lot_number'],
                'reserved_amount' => $card['reserved_amount'],
            ]);
        }
        
        // !! tanımlanan lotlar(cards) sevk emrindeki miktarı karşılasın
        // !! dispatchorder üzerinden reservedstocks oluştur, lotlar ile
    }



    
    public function cannotSubmit()
    {
        return $this->dispatchPivot->dp_amount != $this->coveredAmount();
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
