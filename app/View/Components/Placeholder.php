<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Placeholder extends Component
{

    public $icon;
    public $header;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon = null, $header = null)
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
        return view('components.placeholder');
    }
}
