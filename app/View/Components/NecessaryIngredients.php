<?php

namespace App\View\Components;

use App\Common\Facades\Conversions;
use App\Models\Product;
use Illuminate\View\Component;

class NecessaryIngredients extends Component
{
    public $actions = null; // slot


    public $product;

    public $amount;
    public $unitId;


    public $noHeader;
    public $headerText;

    public $listings = [
        // 'ingredient' => null,
        // 'amount' => null,
        // 'unit' => null,
        // 'cost' => null,
    ];



    
    public function __construct($product, $amount = null, $unitId = null, $noHeader = false, $headerText = null)
    {
        if($product instanceof Product)
            $this->product = $product;
        else $this->product = Product::find($product);

        $this->amount = $amount;
        $this->unitId = $unitId;
        
        $this->noHeader = $noHeader;
        if($headerText) {
            $this->headerText = $headerText;
        } else {
            $this->headerText = __('workorders.items_to_be_used_in_production');
        }

        if(! empty($this->amount) && ! empty($this->unitId))
            $this->listings = $this->product->recipe->calculateNecessaryIngredients($this->amount, $this->unitId);
    }


    public function totalCostFunction()
    {  
        return array_sum(array_column($this->listings, 'cost'));
    }


    public function setIngredientListings()
    {
        

        // foreach($this->product->recipe->ingredients as $key => $ingredient) {
        //     $convertedIngredient = Conversions::toBase($ingredient->pivot->unit_id, $ingredient->pivot->amount);
        //     $mainProduct = Conversions::toBase($this->unitId, $this->amount);

        //     $array[$key] = [
        //         'ingredient' => $ingredient,
        //         'amount' => $mainProduct['amount'] * $convertedIngredient['amount'],
        //         'actual_amount' => $mainProduct['amount'] * $convertedIngredient['amount'],
        //         'unit' => $convertedIngredient['unit'],
        //     ];
        //     if( ! $ingredient->pivot->literal) 
        //         $array[$key]['amount'] = floor($mainProduct['amount'] * $convertedIngredient['amount']); // floor
        // }
    }









    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.necessary-ingredients', ['totalCost' => $this->totalCostFunction()]);
    }
}
