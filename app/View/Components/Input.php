<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    
    public $model;

    public $placeholder;
    
    public $label;
    
    public $type;

    public $noErrors;
    
    public $action;
    public $innerLabel;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $placeholder, $label = null, $type = 'text', $action = null, $innerLabel = null, $noErrors = false)
    {
        $this->model = $model;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->label = $label;
        $this->noErrors = $noErrors;
        $this->action = $action;
        $this->innerLabel = $innerLabel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.input');
    }
}
