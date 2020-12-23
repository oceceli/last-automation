<?php

namespace App\Http\Livewire\Sections\Stockmoves;

use App\Http\Livewire\SmartTable;
use App\Models\StockMove;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    public $model = StockMove::class;
    public $view = 'livewire.sections.stockmoves.datatable';
    

}
