<?php

namespace App\View\Components;

use App\Common\Helpers\Generic;
use Illuminate\View\Component;

class CrudActions extends Component
{
    public $modelName;
    public $pluralModelName;
    public $modelId;

    public $gray;

    public $onlyShow;
    public $addClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modelName, $modelId, $onlyShow = false, $gray = false, $addClass = null)
    {
        $this->modelName = Generic::kebabToSnake($modelName);
        $this->pluralModelName = \Illuminate\Support\Str::plural($modelName);
        $this->modelId = $modelId;

        $this->onlyShow = $onlyShow;
        $this->gray = $gray;
        $this->addClass = $addClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.crud-actions');
    }
}
