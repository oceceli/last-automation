<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class Datepicker extends Component
{

    public $model;
    public $label;
    public $placeholder;
    
    public $type; // datetime, date, time, month, or year
    public $disabledDays;
    public $initialDate;

    public $dId;



    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $placeholder = 'common.date', $label = null, $type = 'date', $disabledDays = null, $initialDate = null, $uniqueKey = null, $dId = null)
    {
        $this->model = $model;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->disabledDays = $disabledDays;
        $this->initialDate = Carbon::parse($initialDate)->format('Y,m,d');

        if($dId) {
            $this->dId = $dId;
        } else {
            $this->dId = 'datepicker_'.$uniqueKey;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.datepicker');
    }
}
