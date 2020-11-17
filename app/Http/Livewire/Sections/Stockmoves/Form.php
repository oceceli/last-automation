<?php

namespace App\Http\Livewire\Sections\Stockmoves;

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

    public $cards = [
        // [
        //     'product_id' => 1,
        //     // 'type' => 'manual_entry',
        //     'direction' => 1,
        //     'amount' => 500,
        //     'datetime' => '16.11.2020',
        // ],
    ];

    public function addCard()
    {
        $this->cards[] = [
            'product_id' => null,
            // 'type' => 'manual',
            'direction' => 1,
            'amount' => null,
            'datetime' => date('d.m.Y H:i:s'),
        ];
    }


    public function toggleDirection($key)
    {
        $this->cards[$key]['direction'] = ! $this->cards[$key]['direction'];
    }

    public function getProductsProperty()
    {
        return Product::all();
    }

    public function getDirectionsProperty()
    {
        return Stock::directions();
    }

    // public function getTypesProperty()
    // { 
    //     return Stock::types();
    // }

}
