<?php

namespace App\Http\Livewire\Sections\Products;

use App\Common\Units\Conversions;
use App\Http\Livewire\Form as Baseform;
use App\Models\Category;
use App\Models\Product;

class Form extends Baseform
{
    public $view = 'livewire.sections.products.form';
    public $model = Product::class;


    /**
     * Edit mode
     */
    public $product;
    public $editMode = false;


    /**
     * Attributes
     */
    public $category_id;
    public $code;
    public $name;
    public $barcode;
    public $min_threshold;
    public $shelf_life;
    public $note;
    public $is_active = true;
    public $producible = false;

    public $unit; // unit tablosuna yazılacak

    /**
     * Refresh the livewire component when category added
     */    
    protected $listeners = ['categoryUpdated' => '$refresh'];

    public function mount($product = null)
    {
        // fill the form fields if edit mode on 
        if($product) {
            $this->editMode = true;
            $this->category_id = $product->category_id;
            $this->code = $product->code;
            $this->name = $product->name;
            $this->barcode = $product->barcode;
            $this->min_threshold = $product->min_threshold;
            $this->shelf_life = $product->shelf_life;
            $this->note = $product->note;
            $this->is_active = (boolean)$product->is_active;
            $this->producible = (boolean)$product->producible;
        }
    }


    /**
     * Computed properties ******************
     */
    public function getCategoriesProperty()
    {
        return Category::all();
    }

    
    public function getUnitsProperty()
    {
        return Conversions::units;
    }
    /************************************* */



    public function submit()
    {
        if($this->editMode) {
            $this->update($this->product);
            Conversions::setBaseUnit($this->product->id, $this->unit); 
        } else {
            $this->create();
            if($product = $this->created) {
                Conversions::setBaseUnit($product->id, $this->unit); 
            }
            $this->reset();
        }
    }


}

