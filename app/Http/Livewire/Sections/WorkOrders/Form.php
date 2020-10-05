<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Http\Livewire\Form as BaseForm;
use App\Models\Recipe;
use App\Models\WorkOrder;

class Form extends BaseForm
{
    public $model = WorkOrder::class;
    
    public $view = 'livewire.sections.workorders.form';


    public $recipe_id;

    public $selected;



    protected function passToView()
    {
        return [
            'products' => $this->products(),
        ];
    }

    public function products()
    {
        $products = [];
        foreach( Recipe::all() as $recipe) {
            if($recipe->product)
                $products[] = $recipe->product;
        }
        return $products;
    }

    

}
