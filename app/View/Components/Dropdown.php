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
    public $dataSourceFunction;
    public $value;
    public $text;
    public $sClass;

    public $triggerOn;
    public $triggerOnEvent;
    public $transition;
    public $clearable;
    public $placeholder;

    public $basic;
    public $initnone;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = null, $key = null,
                                $iModel = null, $iType = 'text', $iPlaceholder = null, 
                                $sId = null, $model, $dataSource = null, $dataSourceFunction = null, $value, $text, $sClass = null,
                                $triggerOn = false, $triggerOnEvent = null, $transition = 'slide', $clearable = false, $placeholder = 'settings',
                                $basic = false, $initnone = false)
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
        $this->dataSourceFunction = $dataSourceFunction;
        $this->value = $value;
        $this->text = $text;
        $this->sClass = $sClass;
        

        $this->triggerOn = $triggerOn; // if set, dataSource should be string. Otherwise it's array.
        $this->triggerOnEvent = $triggerOnEvent;
        $this->transition = $transition;
        $this->clearable = $clearable;
        $this->placeholder = $placeholder;

        $this->basic = $basic;
        $this->initnone = $initnone;

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
