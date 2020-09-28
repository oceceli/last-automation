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
        $user = auth()->user();


        if($user->profile_photo_path) {
            $this->imageUrl = asset('storage/' . $user->profile_photo_path);
        } else {
            $this->imageUrl = 'https://ui-avatars.com/api/?name=' . $user->name;
        }
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
