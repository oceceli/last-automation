<?php

namespace App\View\Components\Dropdown;

use Illuminate\View\Component;

class Search extends Component
{

    public $model;

    public $collection;

    public $value;

    public $text;

    public $placeholder;

    public $transition;

    public $clearable;

    public $label;

    public $sClass;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $collection, $label = null, $value = null, $text = null, $placeholder = 'common.dropdown_placeholder', $transition = 'slide', $clearable = false, $sClass = null)
    {
        $this->model = $model;
        $this->collection = $collection;
        $this->label = $label;
        $this->value = $value;
        $this->text = $text;
        $this->placeholder = $placeholder;
        $this->transition = $transition;
        $this->clearable = $clearable;
        $this->sClass = $sClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.dropdown.search');
    }
}
