<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Listing extends Component
{

    public $title;
    public $addedMaterial;
    public $removeItemFunction;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($addedMaterial, $removeItemFunction)
    {
        $this->addedMaterial = $addedMaterial;
        $this->removeItemFunction = $removeItemFunction;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.listing');
    }
}
