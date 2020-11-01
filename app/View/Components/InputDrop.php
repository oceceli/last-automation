<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputDrop extends Component
{

    public $label;
    
    public $key;

    // input
    public $iModel; 

    public $iType;

    public $iPlaceholder;


    // select
    public $sId;

    public $sModel;

    public $sData;

    public $sValue;

    public $sText;


    public $sTriggerOn;

    public $transition;
    
    public $clearable;
    
    public $sPlaceholder;



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = null, $key = null,
                                $iModel, $iType = 'text', $iPlaceholder = null, 
                                $sId = null, $sModel, $sData, $sValue, $sText, 
                                $sTriggerOn = false, $transition = 'slide', $clearable = false, $sPlaceholder = 'settings')
    {
        $this->label = $label;
        $this->key = $key;

        $this->iModel = $iModel;
        $this->iType = $iType;

        $this->iPlaceholder = $iPlaceholder 
            ? $iPlaceholder
            : $label;

        // I don't know if $sId unnecessary. We will see
        if( ! $sId) {
            $sId = 'uniqueId'.$key; // works if there is only one inputdrop component on the same page, random id didn't work for some reason ??
        }
        $this->sId = $sId;
        $this->sModel = $sModel;
        $this->sData = $sData;
        $this->sValue = $sValue;
        $this->sText = $sText;
        

        $this->sTriggerOn = $sTriggerOn; // if set, sData should be string. Otherwise it's array.
        $this->transition = $transition;
        $this->clearable = $clearable;
        $this->sPlaceholder = $sPlaceholder;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.input-drop');
    }
}
