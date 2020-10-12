<?php

namespace App\Http\Livewire\Sections\Recipes;

use App\Http\Livewire\Form as BaseForm;
use App\Models\Product;
use App\Models\Recipe;
use \Illuminate\Support\Str;

class Form extends BaseForm
{

    public $model = Recipe::class;
    
    public $view = 'livewire.sections.recipes.form';

    public $product_id;

    public $code;

    public $currentProduct;

    public $ingredients = [];
    
    public $test;

    public $testArray = [
        ['id' => 1, 'name' => 'g'],
        ['id' => 2, 'name' => 'kg'],
        ['id' => 3, 'name' => 'ton'],
        ['id' => 4, 'name' => 'palet'],
    ];


    protected function passToView()
    {
        return [
            //
        ];
    }


    public function updatedProductId($id)
    {
        $this->currentProduct = $this->producibleProducts->find($id);
    }

    public function addIngredient($ingredient)
    {
        $this->ingredients[] = $ingredient;
    }

    public function removeIngredient($key)
    {
        unset($this->ingredients[$key]);
    }
    

    public function getProducibleProductsProperty()
    {
        return Product::where('producible', true)->get();
    }

    public function getUnitsProperty()
    {
        return Unit::all(); 
    }

    public function random()
    {
        $string = $this->code;
        $number = 8;
        if($string) {
            $pos = strpos($string, '_');
            if(! $pos) {
                $this->code = $string . '_' . Str::random($number);
            } else {
                $string = substr($string, 0, $pos);
                $this->code = $string . '_' . Str::random($number);
            }
        } else {
            $this->code = 'rct_' . Str::random($number);
        }
        
    }




    


}
