<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Form extends Component
{

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


    /**
     * 
     */
    public function submit()
    {
        // $validated = $this->validation(); // sil

        return $this->create();

    }

    /**
     * Eloquent create and update operations ***************************
     */
    public function create()
    {
        if($this->created = $this->model::create($this->validation())) {
            $this->success = true;
        }
    }

    public function update($entity)
    {
        if($entity->update($this->validation())) {
            $this->success = true;
        }
    }
    /******************************************************************/

    public function validation()
    {
        return $this->validate($this->model::rules()['data']);
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
