<?php

namespace App\Http\Livewire\Sections\Stockmoves;

use App\Common\Facades\Conversions;
use App\Common\Facades\Stock;
use App\Http\Livewire\Form as BaseForm;
use App\Models\Product;
use App\Models\StockMove;

class Form extends BaseForm
{
    public $model = StockMove::class;
    public $view = 'livewire.sections.stockmoves.form';
    public $validate = false;


    // public $product_id;
    // public $type = 'manual_entry';
    // public $direction;
    // public $amount;
    // public $datetime;

    public $cards = [];
    public $units = [];

    protected $rules = [
        'cards.*' => 'array',
        'cards.*.product_id' => 'required|min:1|integer',
        'cards.*.direction' => 'required|boolean',
        'cards.*.amount' => 'required|numeric',
        'cards.*.datetime' => 'nullable|date',

        'cards.*.unit_id' => 'required|integer',
    ];
    
    protected $validationAttributes = [
        'cards.*.amount' => 'Deneme'
    ];


    public function addCard()
    {
        $this->cards[] = [
            'product_id' => null,
            'direction' => 1,
            'amount' => null,
            'datetime' => date('d.m.Y H:i:s'),
            'unit_id' => null,            
        ];
    }
    
    public function getProductsProperty()
    {
        return Product::all();
    }

    public function toggleDirection($key)
    {
        $this->cards[$key]['direction'] = ! $this->cards[$key]['direction'];
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
            $this->emit('sm_product_selected'.$index);
        }
    }


    public function submit()
    {
        $this->validate();
        foreach($this->cards as $card) {
            $amount = Conversions::toBase($card['unit_id'], $card['amount'])['amount']; // stockMove, birimi kullanıcının kaydettiği şekilde göstermiyor, eklemedim. Base'e döndürüyoruz. Haberin olsun
            Stock::newMove($card['product_id'], $amount, $card['direction'], $card['datetime']);
        }
        $this->emit('toast', __('common.saved.title'), __('common.saved.standard'), 'success');
    }

}
