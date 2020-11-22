<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomModal extends Component
{   
    public $header; // slot is optional
    public $active;
    public $theme;
    public $position;
    public $positions = [
        'right' => 'top-0 right-0 bottom-0',
        'left' => 'top-0 left-0 bottom-0',
        'bottom' => 'bottom-0 right-0 left-0 w-full',
        'top' => 'top-0 right-0 left-0 w-full',
        'overlay' => 'top-0 bottom-0 right-0 left-0 w-full',
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($active = null, $theme = 'teal', $header = null, $position = 'right')
    {
        $this->header = $header;
        $this->active = $active;
        $this->theme = $theme;
        $this->position = $this->positions[$position];
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
