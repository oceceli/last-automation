<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputDrop extends Component
{

    public $label;
    

    // input
    public $inputModel; 

    public $inputType;

    public $placeholder;


    // select
    public $selectModel;

    public $selectData;

    public $selectValue;

    public $selectText;



    public $transition;
    
    public $clearable;
    
    public $selectPlaceholder;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = null, 
                                $inputModel, $inputType = 'text', $placeholder = null, 
                                $selectModel, $selectData, $selectValue, $selectText, 
                                $transition = 'slide', $clearable = false, $selectPlaceholder = 'settings')
    {
        $this->label = $label;
        $this->inputModel = $inputModel;
        $this->inputType = $inputType;

        $this->placeholder = $placeholder 
            ? $placeholder
            : $label;
        // $this->placeholder = $placeholder;
        
        $this->selectModel = $selectModel;
        $this->selectData = $selectData;
        $this->selectValue = $selectValue;
        $this->selectText = $selectText;

        $this->transition = $transition;
        $this->clearable = $clearable;
        $this->selectPlaceholder = $selectPlaceholder;
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
