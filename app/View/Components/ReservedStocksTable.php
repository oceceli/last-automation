<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ReservedStocksTable extends Component
{
    public $reservations;
    public $noHead;
    public $noProduct;
    public $emptyMessage;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($reservations, $noHead = false, $noProduct = false, $emptyMessage = 'common.empty')
    {
        $this->reservations = $reservations;
        $this->noHead = $noHead;
        $this->noProduct = $noProduct;
        $this->emptyMessage = $emptyMessage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.reserved-stocks-table');
    }
}
