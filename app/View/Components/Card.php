<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $atClose;
    public $square;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($atClose = null, $square = null)
    {
        $this->atClose = $atClose;
        $this->square = $square;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.card');
    }
}
