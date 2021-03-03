<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OverviewCard extends Component
{


    public $bgColor;
    public $textColor;
    public $icon;
    public $href;

    public $model;
    public $number;
    public $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $number, $text, $icon = 'ship', $bgColor = 'bg-teal-500 hover:bg-teal-700', $textColor = "text-teal-500 hover:text-teal-700", $href = '#')
    {
        $this->model = $model;
        $this->number = $number;
        $this->text = $text;
        
        $this->bgColor = $bgColor;
        $this->textColor = $textColor;
        $this->icon = $icon;
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.overview-card');
    }
}
