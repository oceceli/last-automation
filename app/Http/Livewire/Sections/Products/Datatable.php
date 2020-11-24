<?php

namespace App\Http\Livewire\Sections\Products;

use App\Http\Livewire\Datatable as BaseDatatable;
use App\Models\Product;

class Datatable extends BaseDatatable
{
    public $model = Product::class;
    protected $view = 'livewire.sections.products.datatable';


    public $productsOnPage;

    public $is_active; // bozuk
    public $producible;
    

    public function deHydrate()
    {
        foreach($this->data->items() as $product) 
        {
            $this->is_active[] = $product->is_active;
            $this->producible[] = $product->producible;
        }
        $this->productsOnPage = $this->data->items();
    }

    public function updatedIsActive($value, $index)
    {
        $this->toggler($value, $index, 'is_active');
    }
    public function updatedProducible($value, $index)
    {
        $this->toggler($value, $index, 'producible');
    }

    
    public function toggler($value, $index, $column)
    {
        $productsOnPage = Product::hydrate($this->productsOnPage); 
        if(is_bool($value))
            $productsOnPage->get($index)->update([$column => $value]);
    }
    
}
