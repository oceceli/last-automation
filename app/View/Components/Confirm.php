<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Confirm extends Component
{
    public $question;
    public $atConfirm;
    public $atDeny;

    public $confirm;
    public $deny;
    public $color;

    public $active;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($atConfirm, $atDeny, $active, $question = null, $confirm = 'tamam', $deny = 'vazgeç', $color = 'blue')
    {
        $this->question = $question;
        $this->atConfirm = $atConfirm;
        $this->atDeny = $atDeny;

        $this->confirm = $confirm;
        $this->deny = $deny;
        $this->color = $color;

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
