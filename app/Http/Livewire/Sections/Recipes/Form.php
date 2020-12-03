<?php

namespace App\Http\Livewire\Sections\Recipes;

use App\Common\Units\Conversions;
use App\Http\Livewire\FormHelpers;
use \Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\Recipe;
use Livewire\Component;


class Form extends Component
{
    use FormHelpers;

    public $view = 'livewire.sections.recipes.form';


    public $selectedProduct;
    public $spBaseUnit;

    /**
     * Recipe model attributes *******************************
     */
    public $product_id;
    public $code;

    public $locked = false;

    

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




    /**
     * Whenever product updated
     */
    public function updatingProductId($id)
    {
        $this->reset();
        
        // set selected product property when product_id changed 
        $this->selectedProduct = $this->getProduciblesProperty()->find($id);

        // set baseUnit property for selected unit 
        $this->spBaseUnit = $this->selectedProduct->baseUnit;

        $this->fetchAndSetIngredients();
    }

    /**
     * Get selected product's recipe, set code and ingredients in the form if available 
     */
    private function fetchAndSetIngredients()
    {
        if( ! $recipe = $this->selectedProduct->recipe) 
            return $this->reset('code', 'cards');

        $this->lock();
        $this->code = $recipe->code;
        
        if($recipe->ingredients->isEmpty()) return;

        foreach($recipe->ingredients as $ingredient) {
            // $this->cards[] = array_merge($this->cardForming(), ['ingredient' => $ingredient]);
            $this->cards[] = [
                'ingredient' => $ingredient,
                'unit_id' => $ingredient->pivot->unit_id,
                'amount' => $ingredient->pivot->amount,
                'literal' => $ingredient->pivot->literal,
            ];
        }

    }


    private function cardForming()
    {
        return [
            'ingredient' => null,
            'unit_id' => null,
            'amount' => null,
            'literal' => false, 
        ];
    }



    public function addCard($ingredient)
    {
        // Abort if ingredient is already in card
        if($this->isInCard($ingredient['id'])) {
            return $this->emit('toast', __('common.already_exist'), __('sections/recipes.this_ingredient_already_added'));
        } 

        // Abort if ingredient is $selectedProduct
        if($ingredient['id'] == $this->selectedProduct->id) {
            return $this->emit('toast', __('common.somethings_wrong'), __('sections/recipes.a_product_cannot_have_itself_as_a_ingredient'), 'warning');
        }

        $this->cards[] = array_merge($this->cardForming(), ['ingredient' => $ingredient]);
    }



    public function removeCard($key)
    {
        unset($this->cards[$key]);
    }



    // public function removeAllCards()
    // {
    //     $this->cards = [];
    // }



    public function toggleLiteral($key)
    {
        $this->cards[$key]['literal'] = ! $this->cards[$key]['literal'];
    }

    public function isLocked()
    {
        return $this->locked;
    }
    private function lock()
    {
        $this->locked = true;
    }
    public function unlock()
    {
        $this->locked = false;
    }



    public function calculatedUnit($card)
    {
        if($card['unit_id'] && $card['amount'])
            return $this->getConverted($card)['amount'] . ' ' . $this->getConverted($card)['unit']->name;
    }



    /**
     * Computed properties *****************************
     */

    public function getProduciblesProperty() 
    {
        return Product::getProducibleRecipes();
    }



    public function getCategoriesProperty()
    {
        return Category::all();
    }

    

    public function getConverted($card)
    {
        return Conversions::toBase($card['unit_id'], $card['amount']);
    }

    /************************************************ */




    /**
     * Submit form and attach ingredients to the recipe
     */
    public function submit()
    {
        // validate recipe model only, not ingredients
        $data = $this->validateRecipe();

        // fetch if recipe exists
        $recipe = Recipe::where('product_id', $this->product_id)->first();
        
        // if it already saved in database, just update it
        if($recipe) {
            $recipe->update($data);
        } else {
            // if not, create a new one! 
            $recipe = Recipe::create($data);
        }

        // finally execute syncing operation
        if( ! empty($this->cards)) {
            $this->syncIngredients($recipe);
        } else {
            $this->emit('toast', 'Boş olarak ...', 'Reçete içeriği boş olarak kaydedildi...');
            // $this->reset();
        }
    }


    
    public function validateRecipe()
    {
        return $this->validate([
            'product_id' => 'required|min:1',
            'code' => 'required|unique:recipes,' . $this->product_id,
        ]);
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
        // $this->reset();
    }



    /**
     * return if given ingredient id is already in cards
     */
    public function isInCard($ingredientID)
    {
        $dimension2 = (array_column($this->cards, 'ingredient'));
        return in_array($ingredientID, array_column($dimension2, 'id'));
    }



    /**
     * Produce a random recipe unique code
     */
    public function suggest()
    {
        $string = $this->code;
        $randomString = strtolower(Str::random(8));

        if($this->selectedProduct) {
            if($string) {
                $pos = strpos($string, '_');
                if(! $pos) {
                    $this->code = $string . '_' . $this->selectedProduct->code;
                } else {
                    $string = substr($string, 0, $pos);
                    $this->code = $string . '_' . $randomString;
                }
            } else {
                $this->code = 'rct_' . $this->selectedProduct->code;
            }
        }
    }
    

}