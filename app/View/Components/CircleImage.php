<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CircleImage extends Component
{
    public $imageUrl;
    public $height;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($height)
    {
        $this->height = $height;
        $this->imageUrl = asset('storage/' . auth()->user()->profile_photo_path);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.circle-image');
    }
}
