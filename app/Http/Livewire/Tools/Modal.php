<?php

namespace App\Http\Livewire\Tools;

use Livewire\Component;

class Modal extends Component
{
    public $isActive = false;

    protected $listeners = ['modal' => 'set'];


    public function set()
    {
        $this->isActive = true;
    }

    public function render()
    {
        return view('livewire.tools.modal');
    }
}
