<?php

namespace App\Http\Livewire;


Trait FormHelpers
{

    protected $validateOnly = false;
    
    public function render()
    {
        return $this->view
            ? view($this->view, $this->passToView())
            : dd('view belirtilmedi!');
    }


    public function updated($propertyName)
    {
        if($this->validateOnly)
            $this->validateOnly($propertyName);
    }

    public function passToView()
    {
        return [
            //
        ];
    }

    public function clearFields()
    {
        $this->reset();
        // $this->emit('')
    }
}