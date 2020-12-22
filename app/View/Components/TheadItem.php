<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TheadItem extends Component
{

    public $sortBy;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sortBy = null)
    {
        $this->sortBy = $sortBy;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.thead-item');
    }
}
