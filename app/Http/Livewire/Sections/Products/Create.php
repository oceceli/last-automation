<?php

namespace App\Http\Livewire\Sections\Products;

use App\Common\Units\Conversions;
use App\Http\Livewire\Form as Baseform;
use App\Models\Category;
use App\Models\Product;

class Create extends Baseform
{
    public $view = 'livewire.sections.products.create';

    public $model = Product::class;

    public $category_id;
    public $code;
    public $name;
    public $barcode;
    public $min_threshold;
    public $shelf_life;
    public $note;
    public $is_active = false;
    public $producible = false;

    public $unit; // unit tablosuna yazılacak

    public $success;


    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function getUnitsProperty()
    {
        return Conversions::units;
    }

    public function submit()
    {
        parent::submit();
        if($product = $this->created) {
            Conversions::initUnit($product->id, $this->unit); 
        }
        

    }

}
