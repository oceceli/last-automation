<?php

namespace App\View\Components;

use App\Models\Interfaces\CanReserveStocks;
use Illuminate\View\Component;

class ReservedStocksTable extends Component
{
    public $model;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CanReserveStocks $model)
    {
        $this->model = $model;
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
