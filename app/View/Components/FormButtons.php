<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormButtons extends Component
{

    public $clear;
    public $submit;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($clear = 'clearFields', $submit = '')
    {
        $this->clear = $clear;
        $this->submit = $submit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form-buttons');
    }
}
