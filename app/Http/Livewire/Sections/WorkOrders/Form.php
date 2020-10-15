<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Http\Livewire\Form as BaseForm;
use App\Models\Recipe;
use App\Models\WorkOrder;
use Carbon\Carbon;

class Form extends BaseForm
{
    public $model = WorkOrder::class;
    
    public $view = 'livewire.sections.workorders.form';


    public $recipe_id;
    public $lot_no;
    public $amount;
    public $datetime;
    public $code;
    public $queue;
    public $is_active = false;
    public $in_progress = false;
    public $note;


    public function mount() 
    {
        parent::mount();
        $this->datetime = Carbon::tomorrow()->format('d.m.Y');
    }
    
    

    protected function passToView()
    {
        return [
            //
        ];
    }


    public function getProductsProperty()
    {
        $products = [];
        foreach(Recipe::all() as $recipe) {
            if($recipe->product)
                $products[] = $recipe->product;
        }
        return $products;
    }

    

}
