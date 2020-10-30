<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Http\Livewire\Form as BaseForm;
use App\Models\Product;
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

    public $unit_id;

    // comes from dropdown
    public $product_id;
    public $selectedProduct;

    public function mount() 
    {
        parent::mount();
        $this->datetime = Carbon::tomorrow()->format('d.m.Y');
    }

    public function updatingProductId($id)
    {
        $this->selectedProduct = Product::find($id);
        $this->recipe_id = $this->selectedProduct->recipe->id; // !!! 

    }
    

    public function getUnitsProperty()
    {
        if($this->selectedProduct) {
            return $this->selectedProduct->units;
        }
        // return [
        //    ['id' => 1, 'name' => 'adet'],
        //    ['id' => 2, 'name' => 'g'],
        //    ['id' => 3, 'name' => 'kg'],
        //    ['id' => 4, 'name' => 'ton'],
        //    ['id' => 5, 'name' => 'litre'],
        // ];
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
