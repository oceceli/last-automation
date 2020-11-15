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


    public $product_id;
    public $type;
    public $direction;
    public $amount;
    public $datetime;


    public function getProductsProperty()
    {
        return Product::all();
    }

    public function getTypesProperty()
    { 
        return Stock::types();
    }

}
