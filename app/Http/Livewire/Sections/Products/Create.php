<?php

namespace App\Http\Livewire\Sections\Products;

use App\Models\Product;
use Livewire\Component;

class Create extends Component
{

    public $code;
    public $name;
    public $barcode;
    public $min_threshold;
    public $shelf_life;
    public $note;
    public $is_active = false;
    public $producible = false;

    public $success = false;

    public function render()
    {
        return view('livewire.sections.products.create');
    }

    public function submit()
    {
        $this->validate([
            'code' => ['required', 'min:3'],
            'name' => ['required', 'min:3'],
            'barcode' => ['required', 'numeric'],
            'min_threshold' => 'nullable',
            'shelf_life' => 'nullable',
            'note' => 'nullable',
            'is_active' => 'nullable',
            'producible' => 'nullable',
        ]);

        if(Product::create([
            'code' => $this->code,
            'name' => $this->name,
            'barcode' => $this->barcode,
            'min_threshold' => $this->min_threshold,
            'shelf_life' => $this->shelf_life,
            'note' => $this->note,
            'is_active' => $this->is_active,
            'producible' => $this->producible,
        ])) {
            $this->success = true;
            $this->reset('code', 'name', 'barcode', 'min_threshold', 'shelf_life', 'note', 'is_active', 'producible');
        }

    }

}
