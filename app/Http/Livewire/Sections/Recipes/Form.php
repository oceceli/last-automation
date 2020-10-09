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
    

    protected function passToView()
    {
        return [
            //
        ];
    }


    public function updatedProductId($id)
    {
        $this->currentProduct = $this->products->find($id);
    }

    public function addIngredient($ingredient)
    {
        $this->ingredients[] = $ingredient;
    }

    public function removeIngredient($key)
    {
        unset($this->ingredients[$key]);
    }
    

    public function getProductsProperty()
    {
        return Product::all();
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
            $this->code = Str::random($number);
        }
        
    }


    


}
