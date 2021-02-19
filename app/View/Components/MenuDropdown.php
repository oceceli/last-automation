<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuDropdown extends Component
{

    public $main;
    public $color;
    public $action;
    public $icon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($main, $action, $color = 'teal', $icon = '')
    {
        $this->main = $main;
        $this->color = $color;
        $this->action = $action;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.menu-dropdown');
    }
}
