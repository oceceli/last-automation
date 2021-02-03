<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OverviewCard extends Component
{

    public $color;
    public $icon;
    public $href;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon = 'ship', $color = 'teal', $href = '#')
    {
        $this->color = $color;
        $this->icon = $icon;
        $this->href = $href;
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
