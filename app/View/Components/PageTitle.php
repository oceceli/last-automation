<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageTitle extends Component
{

    public $icon;

    public $header;

    public $subheader;
    

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($header, $icon = null, $subheader = null)
    {
        $this->header = $header;
        $this->icon = $icon;
        $this->subheader = $subheader;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.page-title');
    }
}
