<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LabelValue extends Component
{

    public $label;
    public $value;
    public $hover;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $value, $hover = "gray")
    {
        $this->label = $label;
        $this->value = $value;
        $this->hover = $hover;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.label-value');
    }
}
