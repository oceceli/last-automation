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
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $collection, $value, $text, $placeholder = 'common.dropdown_placeholder')
    {
        $this->model = $model;
        $this->collection = $collection;
        $this->value = $value;
        $this->text = $text;
        $this->placeholder = $placeholder;
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
