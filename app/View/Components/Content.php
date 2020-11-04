<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Content extends Component
{

    public $theme;

    public $buttons;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($theme = null, $buttons = false)
    {
        $this->theme = $theme;
        $this->buttons = $buttons;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.content');
    }
}
