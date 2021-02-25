<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomModal extends Component
{   
    public $header; // slot is optional
    public $active;
    public $theme;
    public $padding;
    // public $headerClass;
    public $atClose;
    public $position;
    public $positions = [
        'right' => 'top-0 right-0 bottom-0 absolute',
        'left' => 'top-0 left-0 bottom-0 absolute',
        'bottom' => 'bottom-0 right-0 left-0 w-full absolute',
        'top' => 'top-0 right-0 left-0 w-full absolute',
        'overlay' => 'top-0 bottom-0 right-0 left-0 w-full absolute',
        'center' => 'm-auto rounded-md',
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($active = null, $theme = 'teal', $padding = null, $atClose = null, $position = 'center')
    {
        // $this->header = $header;
        $this->active = $active;
        $this->theme = $theme;
        // if($position == 'center') $this->headerClass = 'rounded-t-md';
        $this->position = $this->positions[$position];
        if($padding) $this->padding = 'px-6 py-4';
        $this->atClose = $atClose;
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
