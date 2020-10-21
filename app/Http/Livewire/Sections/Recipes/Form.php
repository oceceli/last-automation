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
     * Currently selected product according to product_id
     */
    public $selectedProduct;

    /**
     * Base unit of selected product
     */
    public $baseUnit;

    /**
     * Refers to ingredient cards, called by indexes
     */
    public $ingredients = [];
    public $amount = [];
    public $unit = [];


    /**
     * Submit form and attach ingredients to the recipe
     */
    public function submit()
    {
        // if it already saved in database, just update it
        if($recipe = $this->model::where('product_id', $this->product_id)->first()) {
            $this->update($recipe);
            $this->syncIngredients($recipe);
        } 
        else {
            $this->create();
            $this->syncIngredients($this->created);
        }

    }

    /**
     * Whenever recipe_id attribute updated
     */
    public function updatedProductId($id)
    {
        $this->reset();
        $this->selectedProduct = $this->producibleProducts->find($id);
        // $this->selectedProduct = Product::find($id);

        // set recipe code field if recipe saved once
        if($this->selectedProduct->recipe) {
            $this->code = $this->selectedProduct->recipe->code;
        }
        
        // set baseUnit according to selected product
        $this->baseUnit = $this->selectedProduct->getBaseUnit(); // title unit

        // is selected product already have ingredients
        if($this->selectedProduct->getRecipeIngredients()) {
            $this->ingredients[] = $this->selectedProduct->getRecipeIngredients();
        }

    }


    /**
     * Ingredients add and remove ********************
     */
    public function addIngredient($ingredient)
    {
        if( ! in_array($ingredient, $this->ingredients))
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
    /************************************************ */




    /**
     * Computed properties *****************************
     */
    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function getProducibleProductsProperty()
    {
        return Product::where('producible', true)->get();
    }
    /************************************************ */




    /************************************************
     * Motor functions ******************************
     * *********************************************/

    public function syncIngredients($recipe)
    {
        array_map(function($ingredient, $amount, $unit) use ($recipe){
            $recipe->ingredients()->attach($ingredient['id'], ['amount' => $amount]);
        }, $this->ingredients, $this->amount, $this->unit);
    }

    public function random()
    {
        $string = $this->code;
        $number = 8;
        $randomString = strtolower(Str::random($number));
        if($string) {
            $pos = strpos($string, '_');
            if(! $pos) {
                $this->code = $string . '_' . $randomString;
            } else {
                $string = substr($string, 0, $pos);
                $this->code = $string . '_' . $randomString;
            }
        } else {
            $this->code = 'rct_' . $randomString;
        }
        
    }




    


}
