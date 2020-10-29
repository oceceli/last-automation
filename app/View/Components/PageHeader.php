<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageHeader extends Component
{
    
    public $header;

    public $icon;

    public $subheader;

    public $buttons; // prop

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($header, $subheader = null, $icon = "settings", $buttons = null)
    {
        $this->header = $header;
        $this->subheader = $subheader;
        $this->icon = $icon;
        $this->buttons = $buttons;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.page-header');
    }
    
}
