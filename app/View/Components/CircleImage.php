<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CircleImage extends Component
{
    public $image;
    public $height;

    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($height, $user = null)
    {
        $this->height = $height;
        if($user)
            $this->user = $user;
        else
            $this->user = auth()->user();
        


        $this->image = $this->user->profile_photo_path
            ? asset('storage/' . $this->user->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . $this->user->name;
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
