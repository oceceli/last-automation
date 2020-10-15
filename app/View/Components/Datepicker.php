<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Datepicker extends Component
{

    public $model;

    public $label;

    public $placeholder;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $placeholder = 'common.date', $label = null)
    {
        $this->model = $model;
        $this->label = $label;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.datepicker');
    }
}
