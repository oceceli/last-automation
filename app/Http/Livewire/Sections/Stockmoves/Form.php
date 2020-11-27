<?php

namespace App\Http\Livewire\Sections\Stockmoves;

use App\Common\Facades\Moves;
use App\Http\Livewire\Form as BaseForm;
use App\Models\Product;
use App\Models\StockMove;
use App\Common\Facades\Conversions;

class Form extends BaseForm
{
    public $model = StockMove::class;
    public $view = 'livewire.sections.stockmoves.form';
    public $validate = false;

    public $test = true;

    public $cards = [];

    public $units = []; // for dropdown 
    public $lotNumbers = []; // for dropdown 

    protected $rules = [
        'cards.*' => 'array',
        'cards.*.product_id' => 'required|min:1|integer',
        'cards.*.direction' => 'required|boolean',
        'cards.*.amount' => 'required|numeric',
        'cards.*.datetime' => 'nullable|date',

        'cards.*.unit_id' => 'required|integer',
    ];
    
    protected $validationAttributes = [
        'cards.*.product_id' => 'Ürün',
        'cards.*.direction' => 'Yön',
        'cards.*.amount' => 'Miktar',
        'cards.*.datetime' => 'Tarih',
    ];

    public function mount()
    {
        parent::mount();
        $this->addCard();
    }

    public function addCard()
    {
        $this->cards[] = [
            'product_id' => null,
            'direction' => 0,
            'amount' => null,
            'lot_number' => null,
            'datetime' => date('d.m.Y H:i:s'),
            'unit_id' => null,       
            
            'lotNumberAreaType' => 'dropdown',
        ];
    }

    public function lotNumbers($productId)
    {
        return StockMove::where('product_id', $productId)->pluck('lot_number')->toArray(); 
    }

    public function removeCard($key)
    {
        unset($this->cards[$key]);
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
            $this->units[$index] = $this->getProductsProperty()->find($id)->units;
            $this->lotNumbers[$index] = $this->lotNumbers($id);
            $this->emit('sm_product_selected'.$index);
        }
    }


    public function submit()
    {
        $this->validate();
        foreach($this->cards as $card) {
            $amount = Conversions::toBase($card['unit_id'], $card['amount'])['amount']; // stockMove, birimi kullanıcının kaydettiği şekilde göstermiyor, eklemedim. Base'e döndürüyoruz. Haberin olsun
            Moves::newMove($card['product_id'], $amount, $card['direction'], $card['datetime'], $card['lot_number']);
        }
        $this->emit('toast', __('common.saved.title'), __('common.saved.standard'), 'success');
    }

}
