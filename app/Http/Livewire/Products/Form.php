<?php

namespace App\Http\Livewire\Products;

use App\Common\Units\Conversions;
use App\Http\Livewire\Traits\Categories\CategoriesFormTrait;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;


class Form extends Component
{
    use CategoriesFormTrait;
    
    public $previous;

    /**
     * Edit mode
     */
    public $product;
    public $editMode = false;


    /**
     * Attributes
     */
    public $category_id;
    public $prd_code;
    public $prd_name;
    public $prd_barcode;
    public $prd_min_threshold;
    public $prd_shelf_life;
    public $prd_cost;
    public $prd_note;
    public $prd_is_active = true;
    public $prd_producible = false;

    public $unit_id; // unit tablosuna yazılacak static

    // public $categories;
 
    protected $listeners = ['categoryUpdated'];

    protected function rules()
    {
        return [
            'category_id' => 'nullable|integer',
            'prd_code' => 'required|min:1|unique:products,prd_code,' . optional($this->product)->id,
            'prd_barcode' => 'nullable|numeric|unique:products,prd_barcode,' . optional($this->product)->id,
            'prd_name' => 'required|min:1',
            'prd_shelf_life' => 'required|numeric',
            'prd_producible' => 'required|boolean',
            'prd_is_active' => 'sometimes|nullable|boolean',
            'prd_min_threshold' => 'nullable|numeric',
            'prd_cost' => 'nullable|numeric',
            'prd_note' => 'nullable',
        ];
    }

    public function mount($product = null)
    {
        $this->previous = url()->previous();
        // fill the form fields if edit mode on 
        if($product) {
            $this->setEditMode($product);
        }
    }


    public function updatedCategoryId($id)
    {
        $this->selectedCategory = Category::find($id);
    }

    
    public function categoryUpdated($categoryId = null)
    {
        if($categoryId) {
            $this->category_id = $categoryId;
        } else {
            $this->category_id = null;
        }
    }

    
    public function getCategoriesProperty()
    {
        return Category::all()->toArray();
    }


    
    public function getUnitsProperty()
    {
        if($this->editMode && $this->product) {
            return $this->product->units->toArray(); // ? birim düzenleme ile ilgili bir şeyler düşünmem lazım...
        } else {
            return Conversions::units;
        }
    }


    public function submit()
    {
        $data = $this->validate();

        if($this->editMode) {
            $this->product->update($data);
            $this->createUnit($this->product->id, $this->unit_id); // ?? bu ne
            session()->flash('success', __('products.code_product_updated', ['code' => $this->product->prd_code]));
        } else {
            $product = Product::create($data);
            $this->createUnit($product->id, $this->unit_id); 
            $this->reset();
            session()->flash('success', __('products.product_created'));
        }

        return redirect()->to($this->previous);
    }

    public function createUnit($product_id, $unit_id)
    {
        Conversions::setBaseUnit($product_id, $unit_id);
    }



    private function setEditMode($product)
    {
        $this->setCtgEditMode($product->category);
        $this->editMode = true;

        $this->category_id = $product->category_id;
        $this->prd_code = $product->prd_code;
        $this->prd_name = $product->prd_name;
        $this->prd_barcode = $product->prd_barcode;
        $this->prd_min_threshold = $product->prd_min_threshold;
        $this->prd_shelf_life = $product->prd_shelf_life;
        $this->prd_cost = $product->prd_cost;
        $this->prd_note = $product->prd_note;
        $this->unit_id = optional($product->unit)->id;
        $this->prd_is_active = (boolean)$product->prd_is_active;
        $this->prd_producible = (boolean)$product->prd_producible;
    }

    
    public function render()
    {
        return view('livewire.products.form');
    }


}

