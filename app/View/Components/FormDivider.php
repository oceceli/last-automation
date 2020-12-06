<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormDivider extends Component
{

    public $bottom; // slot
    public $noButtons; 

    public $lClass;
    public $rClass;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($bottom = false, $noButtons = false, $lClass = null, $rClass= null)
    {
        $this->bottom = $bottom;
        $this->noButtons = $noButtons;

        $this->lClass = $lClass;
        $this->rClass = $rClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form-divider');
    }
}
