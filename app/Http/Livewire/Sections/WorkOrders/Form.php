<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Models\WorkOrder;
use Livewire\Component;

class Form extends Component
{

    // public $code;
    // public $name;
    // public $barcode;
    // public $min_threshold;
    // public $shelf_life;
    // public $note;
    // public $is_active = false;
    // public $producible = false;

    // public $success;

    // public function mount()
    // {
    //     $this->success = false;
    // }

    public function render()
    {
        return view('livewire.sections.workorders.form');
    }

    public $test = 'test asşdkjfl';

    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName, WorkOrder::rules()['data']);
    // }

    // public function submit()
    // {
    //     $validated = $this->validate(WorkOrder::rules()['data']);

    //     if(WorkOrder::create($validated)) {
    //         $this->success = true;
    //         $this->reset('code', 'name', 'barcode', 'min_threshold', 'shelf_life', 'note', 'is_active', 'producible');
    //     }

    // }

    // public function clearFields()
    // {
    //     $this->reset();
    // }

}
