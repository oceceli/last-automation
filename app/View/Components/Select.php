<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $model;
    public $collection;
    public $collectionKey;
    // public $value;
    // public $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $collection, $collectionKey = null)
    {
        $this->model = $model;
        $this->collection = $collection;
        // $this->value = $value;
        $this->collectionKey = $collectionKey;
        // $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.select');
    }
}
