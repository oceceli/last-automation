<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{

    public $header; // also a slot
    public $buttons = ""; // slot 
    public $contentClass;

    // public $active; // sil

    // javascript part
    public $blurring;
    public $inverted;

    public $transition;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($header = '', $contentClass = '', $active = false, $transition = 'fly up', $blurring = false, $inverted = false)
    {
        $this->header = $header;
        $this->contentClass = $contentClass;

        // $this->active = $active;

        $this->blurring = $blurring;
        $this->inverted = $inverted;

        $this->transition = $transition;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
