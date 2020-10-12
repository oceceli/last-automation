<?php

namespace App\Http\Livewire\Sections\Products;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Create extends Component
{

    public $category_id;
    public $code;
    public $name;
    public $barcode;
    public $min_threshold;
    public $shelf_life;
    public $note;
    public $is_active = false;
    public $producible = false;

    public $success;

    public function mount()
    {
        $this->success = false;
    }

    public function render()
    {
        return view('livewire.sections.products.create');
    }

    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, Product::rules()['data']);
    }

    public function submit()
    {
        $validated = $this->validate(Product::rules()['data']);

        if(Product::create($validated)) {
            $this->success = true;
            $this->reset('code', 'name', 'barcode', 'min_threshold', 'shelf_life', 'note', 'is_active', 'producible');
        }

    }

    public function clearFields()
    {
        $this->reset();
    }

}
