<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShowButton extends Component
{

    public $action;
    public $route;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action = null, $route = null)
    {
        $this->action = $action;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.show-button');
    }
}
