<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomModal extends Component
{   
    public $header; // slot is optional

    public $active;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($active = false, $header = null)
    {
        $this->active = $active;
        $this->header = $header;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.custom-modal');
    }
}
