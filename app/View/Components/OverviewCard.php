<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OverviewCard extends Component
{

    public $color;
    public $icon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon = 'ship', $color = 'teal')
    {
        $this->color = $color;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.overview-card');
    }
}
