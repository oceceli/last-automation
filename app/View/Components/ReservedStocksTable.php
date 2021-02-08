<?php

namespace App\View\Components;

use App\Models\Interfaces\CanReserveStocks;
use Illuminate\View\Component;

class ReservedStocksTable extends Component
{
    public $model;
    public $noHead;
    public $noProduct;
    public $emptyMessage;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CanReserveStocks $model, $noHead = false, $noProduct = false, $emptyMessage = 'common.empty')
    {
        $this->model = $model;
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
