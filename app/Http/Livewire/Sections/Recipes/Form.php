<?php

namespace App\Http\Livewire\Sections\Recipes;

use App\Common\Units\Conversions;
use App\Http\Livewire\FormHelpers;
use \Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Unit;
use Livewire\Component;


class Form extends Component
{
    use FormHelpers;

    public $view = 'livewire.sections.recipes.form';

    
    public $selectedProduct;

    /**
     * Recipe model attributes *******************************
     */
    public $product_id;
    public $code;
    public $backupCode; 

    public $oldProductId;

    public $locked = false;
    public $recipeExists = false;

    // modals
    public $deleteConfirmModal = false;
    public $formChangedModal = false;

    public $cards = [];
    public $backupCards = [];

    protected $rules = [
        'cards.*' => 'array',
        'cards.*.unit_id' => 'required|integer',
        'cards.*.amount' => 'required|numeric',
        'cards.*.literal' => 'required|boolean',
    ]; 

    protected $validationAttributes = [
        'cards.*.unit_id' => '!!! Birim',
        'cards.*.amount' => '!!! Miktar',
        'cards.*.literal' => '!!! Kesin miktar',
    ];


    /**
     * Whenever product updated
     */
    public function updatingProductId($id)
    {
        if($this->isChangesFoundOnForm()) {
            // save old product id to oldProductId property
            $this->oldProductId = $id;
            return $this->formChangedModal = true;
        }

        $this->reset();
        $this->setForm($id);
    }


    /**
     * Get selected product's recipe, set code and ingredients in the form if available 
     */
    private function setForm($productId)
    {
        // set selectedProduct property
        $this->selectedProduct = $this->getProduciblesProperty()->find($productId);
        
        // if selected product has no recipe then exit
        if( ! $recipe = $this->selectedProduct->recipe)
            return $this->reset('code', 'cards');

        // if there is a recipe for selected product, lock the card so it will be non-editable
        $this->lock();

        // equalize code field with recipe code which comes from database 
        $this->code = $recipe->code;
        
        // if recipe not have any ingredients, return 
        if($recipe->ingredients->isEmpty()) return;

        // if recipe has ingredients, fill in in the cards
        foreach($recipe->ingredients as $ingredient) {
            $this->cards[] = [
                'ingredient' => $ingredient,
                'unit_id' => $ingredient->pivot->unit_id,
                'amount' => $ingredient->pivot->amount,
                'literal' => $ingredient->pivot->literal,
            ];
        }
    }


    /**
     * Detects if something changed on the form by the user
     */
    private function isChangesFoundOnForm()
    {
        return $this->isBackupExists() && ($this->backupCode != $this->code || $this->backupCards != $this->cards);
    }

    
    /**
     * A card's structure
     */
    private function cardForming()
    {
        return [
            'ingredient' => null,
            'unit_id' => null,
            'amount' => null,
            'literal' => false, 
        ];
    }


    /**
     * Add ingredient to form from material modal
     */
    public function addCard($ingredient)
    {
        // Return if ingredient is already in card
        if($this->isInCard($ingredient['id'])) {
            return $this->emit('toast', __('common.already_exist'), __('sections/recipes.this_ingredient_already_added'));
        } 

        // Return if ingredient is $selectedProduct
        if($ingredient['id'] == $this->selectedProduct->id) {
            return $this->emit('toast', __('common.somethings_wrong'), __('sections/recipes.a_product_cannot_have_itself_as_a_ingredient'), 'warning');
        }

        $this->cards[] = array_merge($this->cardForming(), ['ingredient' => $ingredient]);
    }


    /**
     * Remove a card
     */
    public function removeCard($key)
    {
        unset($this->cards[$key]);
    }


    /**
     * Remove recipe from database
     */
    public function removeRecipe()
    {
        $this->selectedProduct->recipe->delete();
        $this->reset();
    }


    /**
     * Opens modal for deletion confirm
     */
    public function openDeleteConfirmModal()
    {
        $this->deleteConfirmModal = true;
    }


    /**
     * Closes deletion confirm modal on cancel
     */
    public function closeDeleteConfirmModal()
    {
        $this->deleteConfirmModal = false;
    } 

   
    /**
     * If product id is updated and changes made in the form 
     */
    public function modalStayHere()
    {
        // close modal
        $this->formChangedModal = false;
        // $this->clearBackups();

        // restore old form
        $this->product_id = $this->oldProductId;

        $this->reset('oldProductId');
    }

    
    /**
     * If formChangedModal got a false
     */
    public function updatedFormChangedModal($bool) // leave selected on the modal 
    {
        if( ! $bool) {
            $this->formChangedModal = false;
            $this->clearBackups();
            $this->reset('cards');
            $this->setForm($this->product_id);
        }
    }


    /**
     * Undo changes made to form 
     */
    public function restoreForm()
    {
        $this->code = $this->backupCode;
        $this->cards = $this->backupCards;
    }


    /**
     * If user made changes on form, it should be restorable from backup 
     */
    public function isRestorable()
    {
        return ! $this->isLocked() && $this->isChangesFoundOnForm();
    }


    /**
     * Toggles literal attribute of ingredient pivot
     */
    public function toggleLiteral($key)
    {
        $this->cards[$key]['literal'] = ! $this->cards[$key]['literal'];
    }


    /**
     * Get unit based on given card
     */
    public function getIngredientUnit($card) 
    {
        return Unit::find($card['unit_id']); // ?? 
    }

    
    /**
     * Return locked property
     */
    public function isLocked()
    {
        return $this->locked;
    }


    /**
     * Perform a locking operation to prevent user from editing the form until it's unlocked
     */
    private function lock()
    {
        $this->locked = true;
        $this->clearBackups();
        $this->recipeExists = true; // ?? submit'in altındaydı buraya almak mantıklı olabilir mi?
    }


    /**
     * Unlock the form, now user can edit or delete the recipe
     */
    public function unlock()
    {
        $this->backupForm();
        $this->locked = false;
    }


    /**
     * Backup form fields
     */
    private function backupForm()
    {
        $this->backupCards = $this->cards;
        $this->backupCode = $this->code;
    }


    /**
     * Get rid of backups
     */
    private function clearBackups()
    {
        if($this->isBackupExists()) {
            $this->reset('backupCode', 'backupCards');
        }
    }


    /**
     * Return backup status
     */
    public function isBackupExists()
    {
        return ! empty($this->backupCards) && ! empty($this->backupCode);
    }

    
    /**
     * Return cards status
     */
    public function isCardsExists()
    {
        return ! empty($this->cards);
    }


    /**
     * Convert units to base
     */
    public function calculatedUnit($card)
    {
        if($card['unit_id'] && $card['amount'])
            return $this->getConverted($card)['amount'] . ' ' . $this->getConverted($card)['unit']->name;
    }


    /**
     * Fetch producible products
     */
    public function getProduciblesProperty() 
    {
        return Product::getProducibleProducts();
    }


    /**
     * Fetch categories
     */
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

        // finally execute the card syncing operation
        if($this->isCardsExists()) {
            $this->syncIngredients($recipe);
        } else {
            $this->emit('toast', 'Boş olarak ...', 'Reçete içeriği boş olarak kaydedildi...');
        }

        // lock the form after saving (lock also clears the backups)
        $this->lock();
    }

    // private function setRecipeExists()
    // {
    //     $this->recipeExists = true;
    // }
    
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
        $this->validate();

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




    /**
     * Lookup tables for avoiding duplicate in blade 
     */
    public function literalClass($key)
    {   
        return [
            true => 'large red chevron left icon',
            false => 'large green chevron right icon',
        ][$this->cards[$key]['literal']];
    }

    public function literalTooltip($key)
    {
        return [
            true => __('sections/recipes.literal'),
            false => __('sections/recipes.non_literal'),
        ][$this->cards[$key]['literal']];
    }

    public function headerText()
    {
        if($this->recipeExists) {
            return $this->isLocked() 
                ? [
                    'main' => __('sections/recipes.recipe_details'),
                    'sub' => __('sections/recipes.see_recipe_details'),
                ]
                : [
                    'main' => __('sections/recipes.edit_recipe'),
                    'sub' => __('sections/recipes.add_edit_or_delete_ingredients'),
                ];
        } else {
            return [
                'main' => __('sections/recipes.recipe_create'),
                'sub' => __('sections/recipes.create_recipe_for_production'),
            ];
        }
    }


    /**
     * Produce a random recipe unique code
     */
    public function suggestCode()
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
                $this->code = 'RCT_' . $this->selectedProduct->code;
            }
        }
    }
    

}