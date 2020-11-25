<?php

namespace App\Http\Livewire\Sections\Recipes;

use App\Common\Units\Conversions;
use App\Http\Livewire\Form as BaseForm;
use \Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\Recipe;

class Form extends BaseForm
{
    public $model = Recipe::class;
    public $view = 'livewire.sections.recipes.form';

    public $selectedProduct;
    public $spBaseUnit;

    /**
     * Recipe attributes *******************************
     */
    public $product_id;
    public $code;

    

    public $cards = [
        // [
        //     'ingredient' => ['name' => 'Ürün2', 'code' => 'RM239', 'id' => 50, 'units' => [['id' => 97, 'name' => 'gram'],['id' => 8, 'name' => 'kg']]],
        //     'unit_id' => 8,
        //     'amount' => 550,
        //     'literal' => false,
        // ],
    ];

    protected $rules = [
        'cards.*' => 'array',
        'cards.*.unit_id' => 'required|integer',
        'cards.*.amount' => 'required|numeric',
        'cards.*.literal' => 'required|boolean',
    ]; 




    public function addCard($ingredient)
    {
        // Abort if ingredient is already in card
        if($this->isInCard($ingredient['id'])) {
            return $this->emit('toast', __('common.already_exist'), __('sections/recipes.this_ingredient_already_added'), 'info');
        } 

        // Abort if ingredient is $selectedProduct
        if($ingredient['id'] == $this->selectedProduct->id) {
            return $this->emit('toast', __('common.somethings_wrong'), __('sections/recipes.a_product_cannot_have_itself_as_a_ingredient'), 'warning');
        }

        $this->cards[] = [
            'ingredient' => $ingredient,
            'unit_id' => null,
            'amount' => null,
            'literal' => false, 
        ];
        // dd($this->cards[$ingredient['id']]['ingredient']['units']);

    }
    public function removeCard($key)
    {
        unset($this->cards[$key]);
        // $this->cards = array_values($this->cards);
        // $this->emit('aCardDeleted'.$key); triggerOnEvent="aCardDeleted{{ $key }}" 
    }
    public function removeAllCards()
    {
        $this->cards = [];
    }

    public function toggleLiteral($key)
    {
        $this->cards[$key]['literal'] = ! $this->cards[$key]['literal'];
    }

    // is unit calculation available for representation 
    // public function isUnitCalcAvailable($card)
    // {
    //     return isset($card['unit_id']) && isset($card['amount']);
    // }

    public function calculatedUnit($card)
    {
        if(isset($card['unit_id']) && isset($card['amount']))
            return $this->getConverted($card)['amount'] . ' ' . $this->getConverted($card)['unit']->name;
    }


    /**
     * Computed properties *****************************
     */

    public function getProduciblesProperty() 
    {
        return Product::getProduciblesDoesntHaveRecipe();
    }

    public function getCategoriesProperty()
    {
        return Category::getCategoriesWithProducts();
    }

    public function getConverted($card)
    {
        // if($card['unit_id'])
            return Conversions::toBase($card['unit_id'], $card['amount']);
    }

    /************************************************ */



    /**
     * Lifecycle hooks ********************************
     */

    public function updatedProductId($id)
    {
        // set selected product property when product_id changed 
        $this->selectedProduct = $this->getProduciblesProperty()->find($id);

        //
        $this->spBaseUnit = $this->selectedProduct->getBaseUnit();
    }
    /********************************************** */



    /**
     * Submit form and attach ingredients to the recipe
     */
    public function submit()
    {
        $this->validate();

        // a product have to be selected to continue 
        if(empty($this->product_id)) {
            return $this->emit('toast', 'common.somethings_missing', 'sections/recipes.please_select_a_product_to_create_recipe', 'warning');
        }

        // count of ingredient, unit_id and amount fields have to be filled before save
        // if ( ! $this->isCardsStable()) {
        //     return $this->emit('toast', 'common.somethings_missing', 'sections/recipes.fill_in_amount_and_unit_correctly', 'warning');
        // }
        

        // if it already saved in database, just update it
        if($recipe = $this->model::where('product_id', $this->product_id)->first()) {
            $this->update($recipe);
        } else {
            $recipe = $this->create();
        }

        // finally execute syncing operation
        if( ! empty($this->cards)) {
            $this->syncIngredients($recipe);
        }
    }

    /**
     * Sync ingredients of recipe
     */
    public function syncIngredients($recipe)
    {
        $cards = $this->cards;
        
        $IDs = [];
        $pivot = [];
        for($i = 0; $i < sizeof($cards); $i++) {
            $IDs[] = $cards[$i]['ingredient']['id'];
            $pivot[] = ['amount' => $cards[$i]['amount'], 'unit_id' => $cards[$i]['unit_id'], 'literal' => $cards[$i]['literal']];
        }
        try {
            $recipe->ingredients()->sync(array_combine($IDs, $pivot));
        } catch (\Throwable $th) {
            $this->emit('toast', 'common.error.title', 'sections/recipes.an_error_occurred_while_adding_ingredients', 'error');
        }
        $this->emit('toast', 'common.saved.title', 'common.saved.changes', 'success');
    }








    /**
     * return if given ingredient id is already in cards
     */
    public function isInCard($ingredientID)
    {
        $dimension2 = (array_column($this->cards, 'ingredient'));
        return in_array($ingredientID, array_column($dimension2, 'id'));
    }

    // public function isCardsStable()
    // {
    //     return $this->columnCount('unit_id') == $this->columnCount('ingredient') && $this->columnCount('ingredient') == $this->columnCount('amount');       
    // }
    // public function columnCount($column)
    // {
    //     return count(array_column($this->cards, $column));
    // }

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