<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Form extends Component
{

    // public $form = [];

    public $success;

    public $model;

    /**
     * Validated and created initiated model's data
     */
    public $created;

    public $view = null;

    public function mount()
    {
        $this->success = false;
    }

    public function render()
    {
        if($this->view)
            return view($this->view, $this->passToView());
        return response('View belirtilmedi!');
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->model::rules()['data']);
    }

    public function submit()
    {
        $validated = $this->validate($this->model::rules()['data']);

        if($this->created = $this->model::create($validated)) {
            $this->success = true;
            // $this->reset('areas');
            return $this;
        }

    }

    public function clearFields()
    {
        $this->reset();
    }

    protected function passToView()
    {
        return [
            //
        ];
    }

}
