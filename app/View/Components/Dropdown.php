<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{

    public $label;
    public $key;

    // input
    public $iModel; 
    public $iType;
    public $iPlaceholder;


    // select
    public $sId;
    public $model;
    public $dataSource;
    public $value;
    public $text;
    public $sClass;

    public $triggerOn;
    public $transition;
    public $clearable;
    public $placeholder;



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = null, $key = null,
                                $iModel = null, $iType = 'text', $iPlaceholder = null, 
                                $sId = null, $model, $dataSource, $value, $text, $sClass = null,
                                $triggerOn = false, $transition = 'slide', $clearable = false, $placeholder = 'settings')
    {
        $this->label = $label;
        $this->key = $key;

        $this->iModel = $iModel;
        $this->iType = $iType;

        $this->iPlaceholder = $iPlaceholder 
            ? $iPlaceholder
            : $label;

        if( ! $sId) {
            $sId = 'uniqueId'.$key; // works if there is only one inputdrop component on the same page, random id didn't work for some reason ??
        }
        $this->sId = $sId;
        $this->model = $model;
        $this->dataSource = $dataSource;
        $this->value = $value;
        $this->text = $text;
        $this->sClass = $sClass;
        

        $this->triggerOn = $triggerOn; // if set, dataSource should be string. Otherwise it's array.
        $this->transition = $transition;
        $this->clearable = $clearable;
        $this->placeholder = $placeholder;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.dropdown');
    }
}
