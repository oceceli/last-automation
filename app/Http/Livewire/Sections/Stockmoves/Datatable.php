<?php

namespace App\Http\Livewire\Sections\Stockmoves;

use App\Http\Livewire\Datatable as BaseDatatable;
use App\Models\StockMove;

class Datatable extends BaseDatatable
{
    public $model = StockMove::class;
    public $view = 'livewire.sections.stockmoves.datatable';
    
    

}
