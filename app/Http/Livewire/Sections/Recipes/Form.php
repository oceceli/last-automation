<?php

namespace App\Http\Livewire\Sections\Recipes;

use App\Http\Livewire\Form as BaseForm;
use App\Models\Category;
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



    public $amount = [];
    public $unit = [];


    protected function passToView()
    {
        return [
            //
        ];
    }

    // submit hazır DEVAM
    public function submit()
    {
        dump($this->amount);
        dump($this->ingredients);
        dump($this->unit);
    }


    public function updatedProductId($id)
    {
        $this->currentProduct = $this->producibleProducts->find($id);
    }

    public function addIngredient($ingredient)
    {
        if(! in_array($ingredient, $this->ingredients))
            $this->ingredients[] = $ingredient;
    }

    public function removeIngredient($key)
    {
        unset($this->ingredients[$key]);
    }
    
    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function getProducibleProductsProperty()
    {
        return Product::where('producible', true)->get();
    }

    // public function getUnproducibleProductsProperty()
    // {
    //     return Product::where('producible', false)->get();
    // }

    public function getUnitsProperty()
    {
        return [
            ['id' => 1, 'name' => 'g'],
            ['id' => 2, 'name' => 'kg'],
            ['id' => 3, 'name' => 'ton'],
            ['id' => 4, 'name' => 'palet'],
        ];
        // return Unit::all(); 
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
