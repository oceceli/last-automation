<?php

namespace App\Http\Livewire\StockMoves;

use App\Models\Product;
use App\Models\StockMove;
use App\Common\Facades\Conversions;
use App\Stocks\Moves;
use Livewire\Component;

class Form extends Component
{
    

    public $model = StockMove::class;
    public $view = 'livewire.stock-moves.form';
    // protected $validateOnly = true;

    // public $test = true;

    public $cards = [];

    public $selectedProduct;

    public $units = []; // for dropdown 
    public $lotNumbers = []; // for dropdown 

    protected $rules = [
        'cards.*' => 'array',
        'cards.*.product_id' => 'required|min:1|integer',
        'cards.*.direction' => 'required|boolean',
        'cards.*.amount' => 'required|numeric',
        'cards.*.datetime' => 'required|date',
        'cards.*.lot_number' => 'required',
        'cards.*.unit_id' => 'required|integer',
    ];
    

    protected function validationAttributes()
    {
        return [
            'cards.*.product_id' => 'Ürün',
            'cards.*.direction' => 'Yön',
            'cards.*.amount' => 'Miktar',
            'cards.*.datetime' => 'Tarih',
            'cards.*.unit_id' => 'Birim',
            'cards.*.lot_number' => 'Lot numarası',
        ];
    }

    public function messages()
    {
        return [
            'cards.*.product_id' => 'Title is required.',
            'cards.*.direction' => 'Status not selected', // ?? deney
        ];
    }



    public function mount($stockMove = null)
    {
        // if($stockMove) {
        //     dd($stockMove->lot_number . " lot numaralı stock move düzenle");
        // }
        $this->addCard();
    }



    public function addCard()
    {
        $this->cards[] = [
            'product_id' => null,
            'direction' => 1,
            'amount' => null,
            'lot_number' => null,
            'datetime' => now(),
            'unit_id' => null,       
            
            'lotNumberAreaType' => 'input',
        ];
    }



    public function lotNumbers($productId)
    {
        return StockMove::where('product_id', $productId)->pluck('lot_number')->toArray();
    }



    public function removeCard($key)
    {
        if($this->isLastCard()) $this->reset();
        unset($this->cards[$key]);
    }



    public function isLastCard()
    {
        return count($this->cards) <= 1;
    }
    


    public function getProductsProperty()
    {
        return Product::all();
    }



    public function toggleDirection($key)
    {
        $currentDirection = $this->cards[$key]['direction'];
        $this->cards[$key]['direction'] = ! $currentDirection;

        $this->cards[$key]['lotNumberAreaType'] = $currentDirection
                                ? 'dropdown' // ??? 
                                : 'input';
        $this->cards[$key]['lot_number'] = null; // empty lot number 
    }


    
    /**
     * Nested product_id on updated event 
     * Fill out the units dropdown based on selected product 
     */
    public function updatedCards($id, $location)
    {
        if(strpos($location, 'product_id')) {
            $index = strtok($location, '.');
            $this->selectedProduct = $this->getProductsProperty()->find($id);
            $this->units[$index] = $this->selectedProduct->units;
            $this->lotNumbers[$index] = $this->lotNumbers($id);

            $this->cards[$index]['unit_id'] = $this->selectedProduct->baseUnit->id;
            $this->emit('sm_product_selected'.$index);
        }
    }



    public function submit()
    {
        $this->validate();
        foreach($this->cards as $card) {
            $amount = Conversions::toBase($card['unit_id'], $card['amount'])['amount']; // stockMove, birimi kullanıcının kaydettiği şekilde göstermiyor, eklemedim. Base'e döndürüyoruz. Haberin olsun
            // Moves::newMove($card['product_id'], $amount, $card['direction'], $card['datetime'], $card['lot_number']);
            (new Moves())->setProductId($card['product_id'])
                         ->setAmount($amount)
                         ->setDirection($card['direction'])
                         ->setDatetime($card['datetime'])
                         ->setLotNumber($card['lot_number'])
                         ->setApproved(true)
                         ->save();
        }
        $this->emit('toast', __('common.saved.title'), __('common.saved.standard'), 'success');
        $this->reset();
    }


    public function render()
    {
        return view('livewire.stock-moves.form');
    }

}
