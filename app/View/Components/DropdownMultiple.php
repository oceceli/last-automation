<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DropdownMultiple extends Component
{

    // public $collection;
    // public $value;
    // public $text;

    public $model;

    public $sId;
    public $maxSelections;

    public $label;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    // public function __construct($collection, $value, $text, $sId)
    public function __construct($model, $label = null, $sId, $maxSelections = null)
    {
        // $this->collection = $collection;
        // $this->value = $value;
        // $this->text = $text;
        $this->model = $model;
        $this->label = $label;
        $this->sId = $sId;
        $this->maxSelections = $maxSelections;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.dropdown-multiple');
    }
}
