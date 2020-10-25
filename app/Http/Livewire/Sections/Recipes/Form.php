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
    public $amounts = [];
    public $units = [];


    public $locked;

    
    public function mount()
    {

    }


    /**
     * Submit form and attach ingredients to the recipe
     */
    public function submit()
    {
        $this->emit('toast', 'Hata!', 'Kayıt başarısız oldu!', 'success');
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
            $this->ingredients = $this->selectedProduct->getRecipeIngredients()['ingredients'];
            $this->amounts = $this->selectedProduct->getRecipeIngredients()['amounts'];
        }
        
        if($this->selectedProduct->recipe) {
            $this->locked = true;
        }
    }

    /**
     * Just before product_id is updated
     */
    public function updatingProductId()
    {
        // Clear the forms
        $this->reset();
    }

    /**
     * Unlocks the form for editing
     */
    public function unlock()
    {
        $this->locked = false;
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
        $this->ingredients = array_values($this->ingredients); // reorder index
        unset($this->amounts[$key]);
        $this->amounts = array_values($this->amounts);
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
        $ingredients = $this->ingredients;
        $amounts = $this->amounts;
        $units = $this->units;

        if(! (sizeof($ingredients) == sizeof($amounts))) {
            //
        }
        $IDs = [];
        $pivot = [];
        for($i = 0; $i < sizeof($ingredients); $i++) {
            $IDs[] = $ingredients[$i]['id'];
            $pivot[] = ['amount' => $amounts[$i]];
        }
        $recipe->ingredients()->sync(array_combine($IDs, $pivot));
    }

    /**
     * Produce a random recipe unique code
     */
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
