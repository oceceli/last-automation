<?php

namespace App\Http\Livewire\Sections\Recipes;

use App\Http\Livewire\Form as BaseForm;
use App\Models\Category;
use App\Models\Product;
use App\Models\Recipe;
use Exception;
use \Illuminate\Support\Str;

class Form extends BaseForm
{

    public $model = Recipe::class;
    public $view = 'livewire.sections.recipes.form';

    /**
     * Recipe_id comes as a prop, so it is read only mode
     */
    public $recipe;


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
    public $units = []; //unit ids actually


    public $locked;

   /**
    * Decide if it's read-only mode
    */
    public function mount($recipe = null)
    {
        if(isset($recipe)) {
            $this->product_id = $recipe->product->id;
            $this->updatedProductId($recipe->product->id);
        } 
    }

    /**
     * Submit form and attach ingredients to the recipe
     */
    public function submit()
    {
        // product should be selected to continue 
        if( ! $this->product_id) {
            return $this->emit('toast', 'common.somethings_missing', 'sections/recipes.please_select_a_product_to_create_recipe', 'warning');
        }

        // A recipe with no-ingredients making no sense. 
        if( ! $this->ingredients) {
            return $this->emit('toast', 'common.somethings_missing', 'sections/recipes.ingredients_should_be_specified_to_save', 'warning');
        }

        // count of ingredient cards should be the same with amounts and units arrays
        if(sizeof($this->ingredients) > sizeof($this->amounts) || sizeof($this->ingredients) > sizeof($this->units)) {
            return $this->emit('toast', 'common.somethings_missing', 'sections/recipes.fill_in_amount_and_unit_correctly', 'warning');
        }

        // if it already saved in database, just update it
        if($recipe = $this->model::where('product_id', $this->product_id)->first()) {
            $this->update($recipe);
        } else {
            $recipe = $this->create();
        }

        // finally execute syncing operation
        $this->syncIngredients($recipe);
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
            $this->units = $this->selectedProduct->getRecipeIngredients()['units'];

        }
        
        if($this->selectedProduct->recipe) {
            $this->locked = true;
        } else $this->locked = false;
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
    public function addIngredient($selectedIngredient)
    {
        $ingredientIDs = collect($this->ingredients)->pluck('id')->toArray();
        if( ! in_array($selectedIngredient['id'], $ingredientIDs))
            $this->ingredients[] = $selectedIngredient;   
    }

    public function removeIngredient($key)
    {
        if(count($this->ingredients) == 1) {
            $this->emit('toast', 'Sonuncu', 'Son içeriği siliyorsunuz'); // prompt
        }
        else {
            unset($this->ingredients[$key]);
            $this->ingredients = array_values($this->ingredients); // reorder index
            unset($this->amounts[$key]);
            $this->amounts = array_values($this->amounts);
            unset($this->units[$key]);
            $this->units = array_values($this->units);
        }
    }

    public function clearIngredients()
    {
        $this->ingredients = [];
        $this->amounts = [];
        $this->units = [];
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
        
        
        $IDs = [];
        $pivot = [];
        for($i = 0; $i < sizeof($ingredients); $i++) {
            $IDs[] = $ingredients[$i]['id'];
            $pivot[] = ['amount' => $amounts[$i], 'unit_id' => $units[$i]];
        }
        try {
            $recipe->ingredients()->sync(array_combine($IDs, $pivot));
        } catch (\Throwable $th) {
            $this->emit('toast', 'common.error.title', 'sections/recipes.an_error_occurred_while_adding_ingredients', 'error');
        }
        $this->emit('toast', 'common.saved.title', 'common.saved.changes', 'success');
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
