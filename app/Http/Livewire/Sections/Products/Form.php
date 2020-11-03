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

    // public $categories;
 
    protected $listeners = ['categoryUpdated'];

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

    
    public function categoryUpdated($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Computed properties ******************
     */
    public function getCategoriesProperty()
    {
        return Category::all()->toArray();
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
            $this->createUnit($this->product->id, $this->unit); 
        } else {
            $this->create();
            if($product = $this->created) {
                $this->createUnit($product->id, $this->unit); 
            }
            $this->reset();
        }
    }

    public function createUnit($product_id, $unitName)
    {
        Conversions::setBaseUnit($product_id, $unitName);
    }


}

