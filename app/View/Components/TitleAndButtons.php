<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TitleAndButtons extends Component
{

    public $title;

    public $icon;

    public $buttons; // prop

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $icon = "settings", $buttons = null)
    {
        $this->title = $title;
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
        return view('components.title-and-buttons');
    }
}
