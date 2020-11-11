<?php

namespace App\Http\Livewire;

use App\Common\Helpers\Generic;
use Livewire\Component;

class Form extends Component
{

    public $success = false;

    public $model;

    /**
     * Validated and created initiated model's data
     */
    public $created;


    public $view = null;

    // public function mount()
    // {
    //     // $this->success = false;
    // }

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
        return $this->create();
    }

    /**
     * Eloquent create and update operations ***************************
     */
    public function create()
    {
        if($this->created = $this->model::create($this->validation())) {
            // $this->success = true;
            $this->emit('toast', 'common.saved.title', __('common.context_created', ['model' => __('modelnames.'.strtolower(Generic::removePath($this->model)))]), 'success');
            return $this->created;
            // $this->reset();
        }
    }

    public function update($entity)
    {
        if($entity->update($this->validation())) {
            $this->emit('toast', 'common.saved.title', __('common.smoothly_updated', ['model' => __('modelnames.'.strtolower(Generic::removePath($this->model)))]), 'success');
            // $this->success = true;
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
