<?php

namespace App\Http\Livewire\Sections\Recipes;

use App\Http\Livewire\Form as BaseForm;
use \Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\Recipe;

class Form extends BaseForm
{
    public $model = Recipe::class;
    public $view = 'livewire.sections.recipes.form';

    /**
     * Recipe attributes *******************************
     */
    public $product_id;
    public $code;

    // public $test;
    // public $test2;

    public $cards = [
        [
            'ingredient' => ['name' => 'Ürün2', 'code' => 'RM239', 'id' => 50, 'units' => [['id' => 97, 'name' => 'gram'],['id' => 8, 'name' => 'kg']]],
            'unit_id' => 4,
            'amount' => [550],
        ],
        [
            'ingredient' => ['name' => 'Ürün1', 'code' => 'RM121', 'id' => 50, 'units' => [['id' => 5, 'name' => 'cm'],['id' => 6, 'name' => 'metre']]],
            'unit_id' => 3,
            'amount' => [550],
        ],
    ];




    public function addCard($ingredient)
    {

        if($this->isInCard($ingredient['id'])) {
            return $this->emit('toast', __('common.already_exist'), __('sections/recipes.this_ingredient_already_added'), 'info');
        } 
        $this->cards[] = ['ingredient' => $ingredient];
        // dd($this->cards[$ingredient['id']]['ingredient']['units']);


    }
    public function removeCard($key)
    {
        unset($this->cards[$key]);
        // $this->cards = array_values($this->cards);
    }



    public function getUnitsOfIngredient($key)
    {
        return ($this->cards[$key]['ingredient']['units']);
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

    /************************************************ */








    

    /**
     * 
     */
    public function isInCard($ingredientID)
    {
        $dimension2 = (array_column($this->cards, 'ingredient'));
        return in_array($ingredientID, array_column($dimension2, 'id'));
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