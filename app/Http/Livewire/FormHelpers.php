<?php

namespace App\Http\Livewire;


Trait FormHelpers
{
    public function render()
    {
        return $this->view
            ? view($this->view, $this->passToView())
            : dd('view belirtilmedi!');
    }

    public function passToView()
    {
        return [
            //
        ];
    }
}