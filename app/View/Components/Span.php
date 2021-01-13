<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Span extends Component
{
    public $tooltip;
    public $position;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tooltip, $position = 'top center')
    {
        $this->tooltip = $tooltip;
        $this->position = $position;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.span');
    }
}
