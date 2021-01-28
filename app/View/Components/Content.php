<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Content extends Component
{
    public $header = null; // slot
    public $bottom = null; // slot

    public $theme;
    public $buttons;
    public $noBorder;



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($theme = null, $buttons = false, $noBorder = false)
    {
        $this->theme = $theme;
        $this->buttons = $buttons;
        $this->noBorder = $noBorder;
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
