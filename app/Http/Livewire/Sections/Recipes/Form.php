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

    /**
     * Recipe attributes
     */
    public $product_id;
    public $code;
    
    /**
     * Currently selected product as product_id
     */
    public $selectedProduct;

    /**
     * Base unit of product
     */
    public $baseUnit;


    public $ingredients = [];
    public $amount = [];
    public $unit = [];


    
    public function submit()
    {
        parent::submit();
        if($recipe = $this->created) {

            array_map(function($ingredient, $amount, $unit) use ($recipe){
                dd($amount);
                $recipe->ingredients()->attach($ingredient['id'], ['amount' => $amount]);
            }, $this->ingredients, $this->amount, $this->unit);

        }
    }


    public function updatedProductId($id)
    {
        $this->reset();
        $this->selectedProduct = $this->producibleProducts->find($id);
        // $this->selectedProduct = Product::find($id);
        
        $this->baseUnit = $this->selectedProduct->getBaseUnit(); // title unit

        $this->ingredients[] = $this->selectedProduct->recipe->ingredients->first();

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

    public function clearIngredients()
    {
        $this->ingredients = [];
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

    // public function getUnitsProperty()
    // {
    //     return $this->ingredients[$index]->units;
    //     // return Unit::all(); 
    // }

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
