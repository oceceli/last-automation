<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Placholder extends Component
{

    public $icon;
    public $header;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon, $header)
    {
        $this->icon = $icon;
        $this->header = $header;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.placholder');
    }
}
