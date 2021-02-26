<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableToolbar extends Component
{

    public $filters = null; // slot


    public $perPage;
    


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.table-toolbar');
    }
}
