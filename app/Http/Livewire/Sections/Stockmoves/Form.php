<?php

namespace App\Http\Livewire\Sections\Stockmoves;

use App\Common\Facades\Moves;
use App\Http\Livewire\Form as BaseForm;
use App\Models\Product;
use App\Models\StockMove;

class Form extends BaseForm
{
    public $model = StockMove::class;
    public $view = 'livewire.sections.stockmoves.form';
    public $validate = false;


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

    public function mount()
    {
        parent::mount();
        $this->addCard();
    }

    public function addCard()
    {
        $this->cards[] = [
            'product_id' => null,
            'direction' => 1,
            'amount' => null,
            'lot_number' => null,
            'datetime' => date('d.m.Y H:i:s'),
            'unit_id' => null,       
            
            'lotNumberAreaType' => 'input',
        ];
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
            // $amount = Conversions::toBase($card['unit_id'], $card['amount'])['amount']; // stockMove, birimi kullanıcının kaydettiği şekilde göstermiyor, eklemedim. Base'e döndürüyoruz. Haberin olsun
            Moves::newMove($card['product_id'], $card['amount'], $card['unit_id'], $card['direction'], $card['datetime'], $card['lot_number']);
        }
        $this->emit('toast', __('common.saved.title'), __('common.saved.standard'), 'success');
    }

}
