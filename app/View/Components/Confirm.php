<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Confirm extends Component
{
    public $question;
    public $atConfirm;
    public $atDeny;

    public $active;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($question, $atConfirm, $atDeny, $active)
    {
        $this->question = $question;
        $this->atConfirm = $atConfirm;
        $this->atDeny = $atDeny;

        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.confirm');
    }
}
